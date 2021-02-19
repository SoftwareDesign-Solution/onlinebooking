import Vue from 'vue';
import { container } from 'tsyringe';
import BurgerMenuService from '../services/burger-menu.service';

Vue.directive('hide-burger-menu', {
    bind(el: Element) {
        const burgerMenuService: BurgerMenuService = container.resolve(BurgerMenuService);

        el.addEventListener('click', () => {
            burgerMenuService.hide();
        });
    }
});
