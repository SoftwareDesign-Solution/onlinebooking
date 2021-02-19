import Vue from 'vue';
import GeneralInfoService from '../../services/general-info.service';
import PopupService from '../../services/popup.service';
import Component from 'vue-class-component';

@Component
export default class TimePopup extends Vue {

    openingHours = null;
    value: { from: number, to: number } = { from: 1, to: 1 };
    min: number = 0;
    max: number = 0;

    private generalInfoService: GeneralInfoService;
    private popupService: PopupService;

    async created() {
        this.generalInfoService = this.$container.resolve(GeneralInfoService);
        this.popupService = this.$container.resolve(PopupService);

        const general = await this.generalInfoService.loadGeneralInfo();
        this.openingHours = {
            weekdays: { start: general.opening_hours_start_weekdays, end: general.opening_hours_end_weekdays },
            weekend: { start: general.opening_hours_start_weekend, end: general.opening_hours_end_weekend }
        }

        this.min = Math.min(general.opening_hours_start_weekend, general.opening_hours_start_weekdays);
        this.max = Math.max(general.opening_hours_end_weekend, general.opening_hours_end_weekdays);

        this.value = {
            from: this.min,
            to: this.max
        }
    }

    onTimeSelected() {
        this.$emit('select', this.value);
        this.popupService.hideCurrentPopup();
    }

}
