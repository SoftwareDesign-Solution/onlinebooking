import Vue from 'vue';
import Component from 'vue-class-component';

const PopupButtonInputProps = Vue.extend({
    props: {
        label: String
    }
});

@Component
export default class PopupButtonInput extends PopupButtonInputProps {
}
