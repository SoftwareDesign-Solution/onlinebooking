import Vue from 'vue';
import Component from 'vue-class-component';
import PopupService from '../../services/popup.service';

@Component
export default class PopupCloseButton extends Vue {
    private popupService: PopupService;

    created() {
        this.popupService = this.$container.resolve(PopupService);
    }

    closePopup() {
        this.popupService.hideCurrentPopup();
    }
}
