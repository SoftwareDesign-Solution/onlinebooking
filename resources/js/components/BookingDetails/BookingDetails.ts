import axios from 'axios';
import BookingsService from '../../services/bookings.service';
import SpecialBookingsService from '../../services/special-bookings.service';
import Vue from 'vue';
import Component from 'vue-class-component';
import UsersService from '../../services/users.service';

const BookingDetailsProps = Vue.extend({
    props: {
        bookingId: Number,
        specialBooking: Boolean
    }
});

@Component
export default class BookingDetails extends BookingDetailsProps {
    booking: any = null;

    private bookingsService: BookingsService;
    private usersService: UsersService;
    private specialBookingsService: SpecialBookingsService;

    $refs!: {
        bookingId: any,
        popup: any
    }

    async created() {
        this.bookingsService = this.$container.resolve(BookingsService);
        this.specialBookingsService = this.$container.resolve(SpecialBookingsService);
        this.usersService = this.$container.resolve(UsersService);

        const booking: any = await (this.specialBooking ?
                this.specialBookingsService.loadSpecialBooking(this.bookingId, true) :
                this.bookingsService.loadBooking(this.bookingId, true)
        );

        booking.user = this.specialBooking ? {
            name: this.booking.name,
            phone: this.booking.phone
        } : booking.user;

        this.booking = booking;
    }

    async deleteBooking() {
        const url = this.specialBooking ? `/api/special-bookings/${this.booking.id}` : `/api/bookings/${this.booking.id}`;
        await axios.delete(url);
        location.reload();
    }

    openPopup() {
        this.$refs.popup.show();
    }

    closePopup() {
        this.$refs.popup.hide();
    }
}
