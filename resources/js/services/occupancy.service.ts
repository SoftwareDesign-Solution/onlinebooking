import * as moment from 'moment';
import BookingsService from './bookings.service';
import RoomsService from './rooms.service';
import Room from '../models/room';
import { injectable } from 'tsyringe';
import SpecialBookingsService from './special-bookings.service';
import GeneralInfoService from './general-info.service';
import GeneralInformation from '../models/general-information';

type BookingSlot = ({ from: string, to: string, room_id: number });

@injectable()
export default class OccupancyService {

    private rooms: Room[];
    private bookings: BookingSlot[];
    private generalInfo: GeneralInformation;

    constructor(private readonly bookingsService: BookingsService,
                private readonly specialBookingsService: SpecialBookingsService,
                private readonly generalInfoService: GeneralInfoService,
                private readonly roomsService: RoomsService) {
    }

    private async loadBookings(from, to) {
        const bookings: BookingSlot[] = await this.bookingsService.loadBookings(from, to);
        const specialBookings: BookingSlot[] = await this.specialBookingsService.loadSpecialBookings(from, to);
        this.bookings = bookings.concat(specialBookings);
    }

    private async loadGeneralInfo() {
        if (this.generalInfo) {
            return;
        }

        this.generalInfo = await this.generalInfoService.loadGeneralInfo();
    }

    private async loadRooms() {
        if (this.rooms) {
            return;
        }

        this.rooms = await this.roomsService.loadAllRooms();
    }

    async calculateHourlyOccupancy(from, to) {
        await this.loadBookings(from, to);
        await this.loadRooms();
        await this.loadGeneralInfo();
        const isWeekend = moment.utc(from).isoWeekday() >= 6;
        const lastSlot = isWeekend ? this.generalInfo.opening_hours_end_weekend : this.generalInfo.opening_hours_end_weekdays;
        const firstSlot = isWeekend ? this.generalInfo.opening_hours_start_weekend : this.generalInfo.opening_hours_start_weekdays;

        const slots = Array.from({ length: lastSlot - firstSlot }, (v, k) => k + firstSlot);
        const maxBookableSlotsPerHour = this.rooms.length;
        const data = [];
        for (const slot of slots) {
            const totalSlotsBooked = this.bookings.filter(booking => {
                const from = moment.utc(booking.from).hour();
                const to = moment.utc(booking.to).hour();
                return from <= slot && slot < to;
            }).length;
            data.push(totalSlotsBooked / maxBookableSlotsPerHour * 100);
        }
        const labels = slots.map(slot => `${slot}`.padStart(2, '0') + ' : 00');
        return { labels, data };
    }

    async calculateDailyOccupancy(from, to) {
        await this.loadBookings(from, to);
        await this.loadRooms();
        await this.loadGeneralInfo();

        from = moment.utc(from);
        to = moment.utc(to).subtract(1, 'day');
        const labels = [];
        const data = [];
        for (let today = from.clone(); to.diff(today, 'day') >= 0; today = today.add(1, 'day')) {
            const isWeekend = today.isoWeekday() >= 6;
            const lastSlot = isWeekend ? this.generalInfo.opening_hours_end_weekend : this.generalInfo.opening_hours_end_weekdays;
            const firstSlot = isWeekend ? this.generalInfo.opening_hours_start_weekend : this.generalInfo.opening_hours_start_weekdays;
            const slotCount = lastSlot - firstSlot;
            const maxBookableSlotsPerDay = this.rooms.length * slotCount;

            labels.push(today.format('D'));

            const bookingHours = this.bookings.filter(booking => {
                let from = moment.utc(booking.from).startOf('day');

                // multi-day bookings are not possible, hence 'from' and 'to' must be on the same day.
                return today.diff(from, 'day') === 0;
            }).map(booking => ({
                ...booking,
                from: moment.utc(booking.from),
                to: moment.utc(booking.to),
            })).filter(booking => {
                return booking.from.hour() >= firstSlot && booking.to.hour() <= lastSlot;
            }).map(booking => {
                let from = booking.from.hour();
                let to = booking.to.hour();
                if (to < from) {
                    return 0;
                }
                return to - from;
            });

            if (bookingHours.length === 0) {
                data.push(0);
                continue;
            }

            const totalSlotsBooked = bookingHours.reduce((prev, current) => prev + current);
            data.push(Math.min(totalSlotsBooked / maxBookableSlotsPerDay * 100, 100));
        }

        return { labels, data }
    }

    async calculateRoomOccupancy(from, to) {
        await this.loadBookings(from, to);
        await this.loadRooms();

        from = moment.utc(from);
        to = moment.utc(to).add(1, 'second');

        const slotCount = 23 - 11;
        const maxBookableSlots = to.diff(from, 'days') * slotCount;

        const data = [];
        const labels = [];
        this.rooms.forEach(room => {
            labels.push(room.name);

            const roomBookings = this.bookings.filter(booking => booking.room_id === room.id);

            if (roomBookings.length === 0) {
                data.push(0);
                return;
            }

            const bookedSlots = roomBookings
                .map(booking => moment(booking.to).diff(moment(booking.from), 'hour'))
                .reduce((prev, current) => prev + current);

            data.push(bookedSlots / maxBookableSlots * 100);
        });

        return { labels, data }
    }

}
