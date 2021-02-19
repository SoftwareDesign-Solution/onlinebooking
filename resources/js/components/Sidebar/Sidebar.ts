import Vue from 'vue';
import Component from 'vue-class-component';

@Component
export default class Sidebar extends Vue {
    isVisible: boolean = false;

    toggle() {
        this.isVisible = !this.isVisible;
    }
}
