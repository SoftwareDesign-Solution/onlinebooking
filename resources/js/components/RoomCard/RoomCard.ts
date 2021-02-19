import Vue from 'vue';
import Component from 'vue-class-component';
import RoomsService from '../../services/rooms.service';
import Room from '../../models/room';
import RoomPhotoService from '../../services/room-photo.service';
import RoomPhoto from '../../models/room-photo';

const RoomCardProps = Vue.extend({
    props: {
        roomId: Number
    }
})

@Component
export default class RoomCard extends RoomCardProps {

    room: Room = null;
    roomPhotos: RoomPhoto[] = null;

    private roomsService: RoomsService;
    private roomPhotoService: RoomPhotoService;

    async created() {
        this.roomsService = this.$container.resolve(RoomsService);
        this.roomPhotoService = this.$container.resolve(RoomPhotoService);
        this.room = await this.roomsService.loadRoom(this.roomId);
        this.roomPhotos = await this.roomPhotoService.loadPhotosForRoom(this.roomId);
    }

}
