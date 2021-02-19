import Component from 'vue-class-component';
import Vue from 'vue';

const SimpleToggleProps = Vue.extend({
    props: {
        name: String,
        default: String,
        options: null
    }
});

@Component
export default class SimpleToggle<T> extends SimpleToggleProps {
    value: T = null;

    $refs!: {
        input: HTMLInputElement;
    }

    mounted() {
        this.value = this.default || this.options[0].value;
    }

    onOptionSelected(option) {
        if (option.link) {
            location.href = option.link;
            return;
        }

        this.value = option.value;
        this.$refs.input.value = option.value;
        this.$emit('change', this.value);
    }



}
