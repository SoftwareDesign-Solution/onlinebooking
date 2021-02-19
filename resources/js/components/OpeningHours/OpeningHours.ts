import Component from 'vue-class-component';
import Vue from 'vue';
import GeneralInfoService from '../../services/general-info.service';

@Component
export default class OpeningHours extends Vue {
    hours: {
        weekday: { from: number, to: number },
        weekend: { from: number, to: number },
    } = null;

    private generalInfoService: GeneralInfoService;

    async created() {
        this.generalInfoService = this.$container.resolve(GeneralInfoService);
        const general = await this.generalInfoService.loadGeneralInfo();

        this.hours = {
            weekday: {
                from: general.opening_hours_start_weekdays,
                to: general.opening_hours_end_weekdays,
            },
            weekend: {
                from: general.opening_hours_start_weekend,
                to: general.opening_hours_end_weekend
            }
        }
    }

    async saveOpeningHours() {
        await this.generalInfoService.patchGeneralInfo({
            opening_hours_start_weekdays: this.hours.weekday.from,
            opening_hours_end_weekdays: this.hours.weekday.to,
            opening_hours_start_weekend: this.hours.weekend.from,
            opening_hours_end_weekend: this.hours.weekend.to
        });
    }
}
