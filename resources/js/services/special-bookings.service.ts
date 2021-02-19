import { injectable } from 'tsyringe';
import SpecialBooking from '../models/special-booking';
import axios from 'axios';
import RoomsService from './rooms.service';

@injectable()
export default class SpecialBookingsService {

    constructor(private readonly roomsService: RoomsService) {
    }

    async createBooking(specialBooking: Partial<SpecialBooking>): Promise<SpecialBooking> {
        return (await axios.post('/api/special-bookings', specialBooking));
    }

    async deleteBooking(id: number): Promise<void> {
        return await axios.delete(`/api/special-bookings/${id}`);
    }

    async loadSpecialBooking(id: number, resolve: boolean = false): Promise<SpecialBooking> {
        let booking = (await axios.get(`/api/special-bookings/${id}`)).data;
        return resolve ? await this.resolveRelationships(booking) : booking;
    }

    async loadSpecialBookings(from?: string, to?: string, resolve: boolean = false): Promise<SpecialBooking[]> {
        const bookings = (await axios.get('/api/special-bookings', {
            params: { from, to }
        })).data;

        return resolve ? await Promise.all(bookings.map(booking => this.resolveRelationships(booking))) : bookings;
    }

    private async resolveRelationships(booking: SpecialBooking): Promise<SpecialBooking> {
        booking.room = await this.roomsService.loadRoom(booking.room_id);
        return booking;
    }

}
