import { injectable } from 'tsyringe';
import VacationBooking from '../models/vacation-booking';
import axios from 'axios';
import RoomsService from './rooms.service';
import Room from '../models/room';
import { Moment } from 'moment';

@injectable()
export default class VacationBookingsService {

    constructor(private readonly roomsService: RoomsService) {
    }

    async createVacationBooking(from: Moment, to: Moment): Promise<VacationBooking> {
        return (await axios.post('/api/vacation-bookings', {
            from: from.toISOString(),
            to: to.toISOString()
        })).data;
    }

    async loadVacationBooking(id: number, resolve: boolean = false): Promise<VacationBooking & { room?: Room }> {
        const booking = (await axios.get(`/api/vacation-bookings/${id}`)).data;
        booking.room = resolve ? await this.roomsService.loadRoom(booking.room_id) : null;
        return booking;
    }

    async loadVacationBookings(from?, to?): Promise<VacationBooking[]> {
        return (await axios.get('/api/vacation-bookings', {
            params: { from, to }
        })).data;
    }

    async deleteVacationBooking(id: number): Promise<void> {
        return await axios.delete(`/api/vacation-bookings/${id}`);
    }
}
