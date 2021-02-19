import Vue from 'vue';
import Component from 'vue-class-component';
import RoomPhotoService from '../../services/room-photo.service';
import RoomPhoto from '../../models/room-photo';

const RoomPhotoUploadProps = Vue.extend({
    props: {
        roomId: Number
    }
});

@Component
export default class RoomPhotoUpload extends RoomPhotoUploadProps {
    photos: RoomPhoto[] = null;

    private roomPhotoService: RoomPhotoService;

    $refs!: {
        input: { value: File } & Vue
    }

    async created() {
        this.roomPhotoService = this.$container.resolve(RoomPhotoService);

        await this.reloadPhotos();
    }

    async reloadPhotos() {
        this.photos = await this.roomPhotoService.loadPhotosForRoom(this.roomId);
    }

    async uploadPhoto() {
        await this.roomPhotoService.uploadPhotoForRoom(this.roomId, this.$refs.input.value);
        await this.reloadPhotos();
    }

    async deletePhoto(photo: RoomPhoto) {
        await this.roomPhotoService.deletePhotoForRoom(this.roomId, photo.filename);
        await this.reloadPhotos();
    }
}
