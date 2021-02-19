import * as moment from 'moment';
import BookingsService from '../../services/bookings.service';
import SpecialBookingsService from '../../services/special-bookings.service';
import Vue from 'vue';
import Component from 'vue-class-component';

@Component
export default class AppointmentsSidebar extends Vue {

    dateInput = moment.utc().toISOString();
    viewType = 'time';
    appointments = null;

    private bookingsService: BookingsService;
    private specialBookingsService: SpecialBookingsService;

    created() {
        this.bookingsService = this.$container.resolve(BookingsService);
        this.specialBookingsService = this.$container.resolve(SpecialBookingsService);
    }

    async mounted() {
        await this.loadAppointments();
    }

    sortAppointments() {
        return this.viewType === 'time' ? this.sortAppointmentsByTime() : this.sortAppointmentsByRoom();
    }

    sortAppointmentsByRoom() {
        if (this.appointments === null) {
            return;
        }

        this.appointments = this.appointments.sort((a, b) => a.room.localeCompare(b.room));
    }

    sortAppointmentsByTime() {
        if (this.appointments === null) {
            return null;
        }

        this.appointments = this.appointments.sort((a, b) => moment(a.from).diff(moment(b.from)))
    }

    async loadAppointments() {
        this.appointments = null;

        const from = moment.utc(this.dateInput).startOf('day').toISOString();
        const to = moment.utc(this.dateInput).endOf('day').toISOString();

        let [bookings, specialBookings] = await Promise.all([
            this.bookingsService.loadBookings(from, to, true),
            this.specialBookingsService.loadSpecialBookings(from, to, true)
        ]);

        let appointments: Appointment[] = [];

        appointments = appointments.concat(bookings.map(booking => ({
            name: booking.user.name,
            from: booking.from,
            to: booking.to,
            room: booking.room.name,
            notes: booking.notes
        })));

        appointments = appointments.concat(specialBookings.map(booking => ({
            name: booking.name,
            from: booking.from,
            to: booking.to,
            room: booking.room.name,
            notes: booking.notes
        })));

        this.appointments = appointments;
        this.sortAppointments();
    }
}

interface Appointment {
    name: string;
    from: string;
    to: string;
    room: string;
    notes: string;
}
