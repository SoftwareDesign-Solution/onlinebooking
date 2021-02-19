import Vue from 'vue';
import Component from 'vue-class-component';

const TimeSelectorProps = Vue.extend({
    props: {
        initial: Number,
        min: { type: Number, default: 0},
        max: { type: Number, default: 24}
    }
});

@Component
export default class TimeSelector extends TimeSelectorProps {
    value: any = null;

    created() {
        this.value = this.initial || this.min || 0;
    }

    increase() {
        if (this.value >= this.max) {
            return;
        }

        this.value += 1;
        this.$emit('change', this.value);
    }

    decrease() {
        if (this.value <= this.min) {
            return;
        }

        this.value -= 1;
        this.$emit('change', this.value);
    }
}
