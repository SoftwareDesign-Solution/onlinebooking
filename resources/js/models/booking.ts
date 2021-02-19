import Room from './room';
import User from './user';

export default class Booking {
    id: number;
    created_at: string;
    updated_at: string;

    from: string;
    to: string;
    user_id: number;
    room_id: number;
    notes: string;

    room?: Room;
    user?: User;
}
