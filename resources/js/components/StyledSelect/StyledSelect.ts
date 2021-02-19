import Vue from 'vue';
import Component from 'vue-class-component';

const StyledSelectProps = Vue.extend({
    props: {
        name: String,
        initialValue: String
    }
});

@Component
export default class StyledSelect extends StyledSelectProps {
    value: any = null;

    $refs!: {
        select: HTMLSelectElement
    }

    created() {
        this.value = this.initialValue;
    }

    mounted() {
        const select = this.$refs.select;
        const observer = new MutationObserver(() => {
            this.value = select.value = this.initialValue || (select.children[0] as HTMLOptionElement).value;
        });
        this.value = select.value = this.initialValue;
        observer.observe(select, { attributes: false, childList: true, subtree: false });
    }
}
