import RoomsService from '../../services/rooms.service';
import Vue from 'vue';
import Room from '../../models/room';
import Component from 'vue-class-component';
import PopupService from '../../services/popup.service';

@Component
export default class RoomsPopup extends Vue {
    rooms: Room[] = [];
    selectedRooms: Room[] = [];

    private roomsService: RoomsService;
    private popupService: PopupService;

    async created() {
        this.roomsService = this.$container.resolve(RoomsService);
        this.popupService = this.$container.resolve(PopupService);

        this.rooms = [];
        this.rooms = (await this.roomsService.loadAllRooms())
            .filter(room => room.active);
    }

    isSelected(room) {
        return this.selectedRooms.includes(room);
    }

    toggleSelection(room) {
        if (this.isSelected(room)) {
            this.selectedRooms.splice(this.selectedRooms.indexOf(room), 1);
            return;
        }

        this.selectedRooms.push(room);
    }

    selectAll() {
        if (this.allSelected()) {
            this.selectedRooms = [];
            return;
        }

        this.selectedRooms = [];
        this.rooms.forEach(room => this.selectedRooms.push(room));
    }

    allSelected() {
        return !this.rooms.some(room => !this.selectedRooms.includes(room))
    }

    finishRoomSelection() {
        this.$emit('select', this.selectedRooms);
        this.popupService.hideCurrentPopup();
    }

}
