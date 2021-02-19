import Vue from 'vue';
import Component from 'vue-class-component';
import PopupService from '../../services/popup.service';

const PopupProps = Vue.extend({
    props: {
        container: String,
        name: String
    }
})

@Component
export default class Popup extends PopupProps {
    popupContainer: Element = null;
    open: boolean = false;

    private popupService: PopupService;

    created() {
        this.popupService = this.$container.resolve(PopupService);
        this.popupContainer = this.popupService.createPopupContainer(this.container);
        this.popupService.register(this);
    }

    mounted() {
        this.popupContainer.appendChild(this.$el);
    }

    show() {
        this.popupService.showPopup(this);
    }

    hide() {
        this.popupService.hideCurrentPopup();
    }

    focus() {
    }
}

