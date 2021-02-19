import axios from 'axios';
import Room from '../models/room';
import { injectable } from 'tsyringe';

@injectable()
export default class RoomsService {

    async loadAllRooms(): Promise<Room[]> {
        return window.OnlineBooking.rooms;
    }

    async loadRoom(id: number): Promise<Room> {
        return (await axios.get(`/api/rooms/${id}`)).data;
    }

}
