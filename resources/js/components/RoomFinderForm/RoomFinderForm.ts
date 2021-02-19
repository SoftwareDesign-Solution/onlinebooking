import RoomsService from '../../services/rooms.service';
import Vue from 'vue';
import Component from 'vue-class-component';
import Room from '../../models/room';
import moment, { Moment } from 'moment';
import UsersService from '../../services/users.service';
import GeneralInfoService from '../../services/general-info.service';

@Component
export default class RoomFinderForm extends Vue {
    selectedRooms: Room[] = [];
    selectedDate: { from: Moment, to: Moment } = { from: moment.utc(), to: moment.utc().add('3', 'days') };
    selectedTime: { from: number, to: number } = null;
    type: 'single' | 'multiple' = 'single';
    rooms: Room[] = [];
    isAuthenticated: boolean = false;

    private roomsService: RoomsService;
    private usersService: UsersService;
    private generalInfoService: GeneralInfoService;

    async created() {
        this.roomsService = this.$container.resolve(RoomsService);
        this.usersService = this.$container.resolve(UsersService);
        this.generalInfoService = this.$container.resolve(GeneralInfoService);

        this.rooms = (await this.roomsService.loadAllRooms()).filter(room => room.active);
        this.isAuthenticated = await this.usersService.isAuthenticated();
        const general = await this.generalInfoService.loadGeneralInfo();

        this.selectedTime = {
            from: Math.min(general.opening_hours_start_weekend, general.opening_hours_start_weekdays),
            to: Math.max(general.opening_hours_end_weekend, general.opening_hours_end_weekdays)
        }

        this.selectedRooms = this.rooms;
    }

}
