import Room from './room';

export default class SpecialBooking {
    id: number;
    created_at: string;
    updated_at: string;

    from: string;
    to: string;
    name: string;
    phone: string;
    room_id: number;
    notes: string;

    room?: Room;
}

