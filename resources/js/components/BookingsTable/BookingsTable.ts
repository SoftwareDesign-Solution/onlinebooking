import Vue from 'vue';
import Component from 'vue-class-component';
import BookingsService from '../../services/bookings.service';
import RoomsService from '../../services/rooms.service';
import GeneralInfoService from '../../services/general-info.service';
import Room from '../../models/room';
import GeneralInformation from '../../models/general-information';
import * as moment from 'moment';
import DateRangeService from '../../services/date-range.service';
import SpecialBookingsService from '../../services/special-bookings.service';
import VacationBookingsService from '../../services/vacation-bookings.service';

// @ts-ignore
import Popup from '../Popup/Popup';
import User from '../../models/user';
import { Moment } from 'moment';

type BookingSlot = {
    id: number,
    from: Moment,
    to: Moment,
    user: Partial<User>,
    room: Room,
    notes: string,
    type: 'regular' | 'special'
}

const BookingsTableProps = Vue.extend({
    props: {
        initialDate: String
    }
});

export interface SlotSelectedEvent {
    room: Room,
    date: string,
    slot: number
}

@Component
export default class BookingsTable extends BookingsTableProps {

    bookings: BookingSlot[] = null;
    rooms: Room[] = null;
    generalInfo: GeneralInformation = null;
    hasVacationBooked: boolean = false;
    selectedBooking: BookingSlot = null;
    hourSlots: number[] = null;
    loaded: boolean = false;
    date: string = moment.utc().toISOString();

    $refs!: {
        bookingPopup: Popup
    }

    private bookingsService: BookingsService;
    private specialBookingsService: SpecialBookingsService;
    private vacationBookingService: VacationBookingsService;
    private roomsService: RoomsService;
    private generalInfoService: GeneralInfoService;
    private dateRangeService: DateRangeService;

    async created() {
        this.bookingsService = this.$container.resolve(BookingsService);
        this.specialBookingsService = this.$container.resolve(SpecialBookingsService);
        this.vacationBookingService = this.$container.resolve(VacationBookingsService);
        this.roomsService = this.$container.resolve(RoomsService);
        this.generalInfoService = this.$container.resolve(GeneralInfoService);
        this.dateRangeService = this.$container.resolve(DateRangeService);

        this.date = this.initialDate ?? moment.utc().toISOString();
        this.generalInfo = await this.generalInfoService.loadGeneralInfo();
        this.rooms = await this.roomsService.loadAllRooms();
        this.hourSlots = this.calculateHourSlots();
        await this.loadBookings();
        this.loaded = true;
    }

    async reload() {
        this.loaded = false;
        await this.loadBookings();
        this.loaded = true;
    }

    async setDate(date: string) {
        this.loaded = false;
        this.date = date;
        this.hourSlots = this.calculateHourSlots();
        await this.loadBookings();
        this.loaded = true;
    }

    async loadBookings() {
        const range = this.dateRangeService.createRange("day", moment.utc(this.date));
        this.hasVacationBooked = (await this.vacationBookingService.loadVacationBookings(range.from, range.to)).length > 0;
        const bookings = await this.bookingsService.loadBookings(range.from, range.to, true);
        const specialBookings = await this.specialBookingsService.loadSpecialBookings(range.from, range.to, true);

        this.bookings = []
            .concat(bookings.map(booking => ({
                ...booking,
                from: moment.utc(booking.from),
                to: moment.utc(booking.to),
                type: 'regular'
            }) as BookingSlot))
            .concat(specialBookings.map(booking => ({
                ...booking,
                type: 'special',
                from: moment.utc(booking.from),
                to: moment.utc(booking.to),
                user: {
                    name: booking.name,
                    phone: booking.phone
                }
            }) as BookingSlot));
    }

    calculateHourSlots(): number[] {
        if (moment.utc(this.date).isoWeekday() >= 6) {
            return new Array(this.generalInfo.opening_hours_end_weekend - this.generalInfo.opening_hours_start_weekend)
                .fill(1)
                .map((_, i) => i + this.generalInfo.opening_hours_start_weekend);
        } else {
            return new Array(this.generalInfo.opening_hours_end_weekdays - this.generalInfo.opening_hours_start_weekdays)
                .fill(1)
                .map((_, i) => i + this.generalInfo.opening_hours_start_weekdays);
        }
    }

    isBooked(room: Room, slot: number): boolean {
        return !!this.getBooking(room, slot);
    }

    getBooking(room: Room, slot: number): BookingSlot {
        return this.bookings
            .filter(booking => booking.room.id === room.id)
            .filter(booking => booking.from.hour() <= slot)
            .filter(booking => booking.to.hour() > slot)[0];
    }

    async deleteBooking(bookingSlot: BookingSlot) {
        if (bookingSlot.type === 'regular') {
            await this.bookingsService.deleteBooking(bookingSlot.id);
        } else {
            await this.specialBookingsService.deleteBooking(bookingSlot.id);
        }

        this.$refs.bookingPopup.hide();
        this.bookings = this.bookings.filter(booking => booking.id !== bookingSlot.id)
    }

    openBookingPopup(room: Room, slot: number) {
        this.selectedBooking = this.getBooking(room, slot);
        this.$refs.bookingPopup.show();
    }

}
