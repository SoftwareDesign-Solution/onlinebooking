import { injectable } from 'tsyringe';
import axios from 'axios';
import RoomPhoto from '../models/room-photo';

@injectable()
export default class RoomPhotoService {

    async loadPhotosForRoom(roomId: number): Promise<RoomPhoto[]> {
        return (await axios.get(`/api/rooms/${roomId}/photos`)).data
    }

    async uploadPhotoForRoom(roomId: number, file: File): Promise<void> {
        const formData = buildFormData(file);
        await axios.post(`/api/rooms/${roomId}/photos`, formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });
    }

    async deletePhotoForRoom(roomId: number, filename: string): Promise<void> {
        await axios.delete(`/api/rooms/${roomId}/photos/${filename}`);
    }

}

function buildFormData(file: File): FormData {
    const formData = new FormData();
    formData.append('file', file);
    return formData;
}
