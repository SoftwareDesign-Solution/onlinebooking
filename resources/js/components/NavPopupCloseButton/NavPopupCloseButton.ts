import Vue from 'vue';
import Component from 'vue-class-component';
import PopupService from '../../services/popup.service';

@Component
export default class NavPopupCloseButton extends Vue {
    isPopupOpen: boolean = false;

    private interval = null;
    private popupService: PopupService;

    created() {
        this.popupService = this.$container.resolve(PopupService);
        this.isPopupOpen = this.popupService.isPopupOpen;
    }

    mounted() {
        this.interval = setInterval(() => {
            this.isPopupOpen = this.popupService.isPopupOpen
        }, 20);
    }

    beforeDestroy() {
        clearInterval(this.interval);
    }

    closeCurrentPopup() {
        this.popupService.hideCurrentPopup();
    }
}
