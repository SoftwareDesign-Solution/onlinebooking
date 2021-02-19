import { DirectiveBinding } from 'vue/types/options';
import Vue from 'vue';
import PopupService from '../services/popup.service';
import {container} from "tsyringe";

Vue.directive('show-popup', {
    bind(el: Element, binding: DirectiveBinding) {
        const popupService: PopupService = container.resolve(PopupService);

        el.addEventListener('click', () => {
            popupService.showPopupByName(binding.value);
        });
    }
});
