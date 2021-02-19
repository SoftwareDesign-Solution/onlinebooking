import Component from 'vue-class-component';
import Vue from 'vue';
import * as moment from 'moment';
import { Moment } from 'moment';

const BookingsDayToggleProps = Vue.extend({
    props: {
        startDate: String
    }
});

@Component
export default class BookingsDayToggle extends BookingsDayToggleProps {

    date: Moment = null;

    created() {
        this.date = this.startDate ? moment.utc(this.startDate, 'YYYY-MM-DD') : moment();
    }

    nextDay() {
        this.date.add(1, 'day');
        this.$emit('change', this.date.toISOString());
        this.$forceUpdate();
    }

    prevDay() {
        this.date = this.date.subtract(1, 'day');
        this.$emit('change', this.date.toISOString());
        this.$forceUpdate();
    }

    setDate(date: Moment) {
        this.date = date;
        this.$emit('change', this.date.toISOString());
        this.$forceUpdate();
    }

}
