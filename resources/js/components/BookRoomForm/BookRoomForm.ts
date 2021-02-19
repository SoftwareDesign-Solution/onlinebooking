import Vue from 'vue';
import Component from 'vue-class-component';

const BookingsTableProps = Vue.extend({
    props: {
        hourFrom: Number,
        hourTo: Number,
        minHour: Number,
        maxHour: Number
    }
});

@Component
export default class BookRoomForm extends BookingsTableProps {

    value: { from: number, to: number } =  { from: 0, to: 24 };

    created() {
        this.value = {
            from: this.hourFrom,
            to: this.hourTo
        }
    }

}
