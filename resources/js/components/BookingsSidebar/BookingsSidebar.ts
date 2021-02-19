import * as moment from 'moment';
import { Moment } from 'moment';
import Vue from 'vue';
import RoomsService from '../../services/rooms.service';
import Component from 'vue-class-component';
import Room from '../../models/room';
import VacationBookingsService from '../../services/vacation-bookings.service';
import SpecialBookingsService from '../../services/special-bookings.service';
import UsersService from '../../services/users.service';
import User from '../../models/user';

@Component
export default class BookingsSidebar extends Vue {
    rooms: Room[] = null;
    dateInput: { start: string, end?: string } = moment.utc().toISOString() as any;
    specialBookingType = 'ahead';
    hasVacationBooked = false;
    repeatBooking = false;
    repetitions = 0;

    bookingModel = {
        name: null,
        phone: null,
        notes: null
    }

    $refs!: {
        nameInput: HTMLInputElement,
        hourFromInput: any;
        hourToInput: any;
        roomInput: any;
        repeatCheckBox: HTMLInputElement;
        repeatInput: HTMLInputElement;
    }

    private roomsService: RoomsService;
    private vacationBookingService: VacationBookingsService;
    private specialBookingsService: SpecialBookingsService;
    private userService: UsersService;

    async created() {
        this.roomsService = this.$container.resolve(RoomsService);
        this.vacationBookingService = this.$container.resolve(VacationBookingsService);
        this.specialBookingsService = this.$container.resolve(SpecialBookingsService);
        this.userService = this.$container.resolve(UsersService);
        this.rooms = await this.roomsService.loadAllRooms();
    }

    async mounted() {
        await this.checkVacationBooking();
    }

    async checkVacationBooking() {
        if (!this.dateInput) {
            return;
        }

        const startDate = moment.utc(this.dateInput.start).startOf('day');
        const endDate = this.dateInput.end ? moment.utc(this.dateInput.end).startOf('day') : startDate.clone().endOf('day');

        this.hasVacationBooked = (await this.vacationBookingService.loadVacationBookings(startDate.toISOString(), endDate.toISOString())).length > 0;
    }

    async bookVacation() {
        if (!this.dateInput) {
            return;
        }

        if (this.hasVacationBooked) {
            return;
        }

        const startDate = moment.utc(this.dateInput.start).startOf('day');
        const endDate = this.dateInput.end ? moment.utc(this.dateInput.end).startOf('day') : startDate.clone().endOf('day');

        await this.vacationBookingService.createVacationBooking(startDate, endDate);
        this.hasVacationBooked = true;

        this.$emit('booked');
    }

    async deleteVacation() {
        if (!this.dateInput) {
            return;
        }

        if (!this.hasVacationBooked) {
            return;
        }

        const startDate = moment.utc(this.dateInput.start).startOf('day');
        const endDate = this.dateInput.end ? moment.utc(this.dateInput.end).startOf('day') : startDate.clone().endOf('day');

        const bookings = await this.vacationBookingService.loadVacationBookings(startDate.toISOString(), endDate.toISOString());
        await Promise.all(bookings.map(booking => this.vacationBookingService.deleteVacationBooking(booking.id)));

        this.hasVacationBooked = false;

        this.$emit('booked');
    }

    async bookAhead() {
        if (!this.dateInput) {
            return;
        }

        const startDate = moment.utc(this.dateInput.start).startOf('day');
        const endDate = moment.utc(this.dateInput.end).startOf('day');
        const isSingleDate = !this.dateInput.end || startDate === endDate;

        let dates = isSingleDate ? [startDate] : [];
        if (!isSingleDate) {
            for (let m = startDate; m.diff(endDate, 'days') <= 0; m.add(1, 'days')) {
                dates.push(m.clone());
            }
        }

        if (this.repeatBooking && this.repetitions > 0) {
            const copiedDates: Moment[] = [];
            for (let i = 0; i < this.repetitions; i ++) {
                dates.forEach(date => {
                    copiedDates.push(date.clone().add('1', 'week'));
                });
            }
            dates = dates.concat(copiedDates);
        }

        await Promise.all(dates
            .map(date => {
                return {
                    from: date.clone().hour(this.$refs.hourFromInput.value),
                    to: date.clone().hour(this.$refs.hourToInput.value)
                }
            })
            .map(({ from, to }) => {
                return this.specialBookingsService.createBooking({
                    from: from.toISOString(),
                    to: to.toISOString(),
                    room_id: this.$refs.roomInput.value,
                    ...this.bookingModel
                });
            }));

        this.bookingModel.name = null;
        this.bookingModel.phone = null;
        this.bookingModel.notes = null;
        this.$refs.roomInput.value = null;

        this.$emit('booked');
    }

    onSlotSelected(event: { room: Room, slot: number, date: string }) {
        this.specialBookingType = 'ahead';
        this.$refs.roomInput.value = event.room.id;
        this.$refs.hourFromInput.value = event.slot;
        this.$refs.hourToInput.value = event.slot + 1;
        this.dateInput = {
            start: moment.utc(event.date).format('YYYY-MM-DD')
        };
    }

    async suggestUsers(input: string): Promise<User[]> {
        return await this.userService.searchUsers(input);
    }

    selectUserSuggestion(user: User) {
        this.bookingModel.name = user.name;
        this.bookingModel.phone = user.phone;
    }

}
