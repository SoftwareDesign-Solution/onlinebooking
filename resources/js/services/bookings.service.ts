import axios from 'axios';
import Booking from '../models/booking';
import SpecialBooking from '../models/special-booking';
import VacationBooking from '../models/vacation-booking';
import { injectable } from 'tsyringe';
import UsersService from './users.service';
import RoomsService from './rooms.service';

@injectable()
export default class BookingsService {

    constructor(private readonly usersService: UsersService,
                private readonly roomsService: RoomsService) {
    }

    async deleteBooking(id: number): Promise<void> {
        return await axios.delete(`/api/bookings/${id}`);
    }

    async loadBooking(id: number, resolve: boolean = false): Promise<Booking> {
        const booking = (await axios.get(`/api/bookings/${id}`)).data;
        return resolve ? await this.resolveRelationships(booking) : booking;
    }

    async loadBookings(from?: string, to?: string, resolve: boolean = false): Promise<Booking[]> {
        const bookings = (await axios.get('/api/bookings', {
            params: { from, to }
        })).data;

        return resolve ? await Promise.all(bookings.map(booking => this.resolveRelationships(booking))) : bookings;
    }

    async loadSpecialBookings(from?, to?): Promise<SpecialBooking[]> {
        return (await axios.get('/api/special-bookings', {
            params: { from, to }
        })).data;
    }

    async loadVacationBookings(from: string, to: string): Promise<VacationBooking[]> {
        return (await axios.get('/api/vacation-bookings', {
            params: { from, to }
        })).data;
    }

    private async resolveRelationships(booking: Booking): Promise<Booking> {
        const [user, room] = await Promise.all([
            this.usersService.loadUser(booking.user_id),
            this.roomsService.loadRoom(booking.room_id)
        ]);
        booking.user = user;
        booking.room = room;
        return booking;
    }
}
