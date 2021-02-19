import BookingsService from '../../services/bookings.service';
import DateRangeService from '../../services/date-range.service';
import * as moment from 'moment';
import { Moment } from 'moment';
import VacationBooking from '../../models/vacation-booking';
import Vue from 'vue';
import Component from 'vue-class-component';
import PopupService from '../../services/popup.service';

@Component
export default class DatePopup extends Vue {

    rawModel: { start: string, end: string } = null;
    hasVacationCollision: boolean = false;
    collisionDates: Moment[] = [];

    private parsedModel: { from: Moment, to: Moment } = { from: null, to: null };

    private bookingsService: BookingsService;
    private rangeService: DateRangeService;
    private popupService: PopupService;

    created() {
        this.bookingsService = this.$container.resolve(BookingsService);
        this.rangeService = this.$container.resolve(DateRangeService);
        this.popupService = this.$container.resolve(PopupService);
    }

    // manually parsing the output because the fallback parser (which is the native js new Date())
    // has problems with the default date format on some browsers (e.g. Safari)
    transformRawModel() {
        this.parsedModel.from = moment.utc(this.rawModel.start, 'YYYY-MM-DD hh:mm a').startOf('day')
        this.parsedModel.to = this.rawModel.end ? moment.utc(this.rawModel.end, 'YYYY-MM-DD hh:mm a').endOf('day') : null;
    }

    async checkVacationBooking() {
        let bookings: VacationBooking[];
        if (!this.parsedModel.to) {
            const range = this.rangeService.createRange("day", this.parsedModel.from)
            bookings = await this.bookingsService.loadVacationBookings(range.from, range.to);
        } else {
            const from = this.parsedModel.from.toISOString();
            const to = this.parsedModel.to.toISOString();
            bookings = await this.bookingsService.loadVacationBookings(from, to);
        }
        this.hasVacationCollision = bookings.length > 0;
        this.collisionDates = [];

        if (this.hasVacationCollision) {
            this.collisionDates = bookings
                .map(({ from, to }) => [from, to])
                .reduce((prev, current) => prev.concat(current))
                .map(date => moment.utc(date));
        }
    }

    isSingleDate() {
        if (!this.parsedModel) {
            return;
        }

        if (!this.parsedModel.to) {
            return true;
        }

        return this.parsedModel.to.diff(this.parsedModel.from, "day") < 1;
    }

    selectDates() {
        this.popupService.hideCurrentPopup();
        this.$emit('select', this.parsedModel);
    }
}
