import Vue from 'vue';
import { container } from 'tsyringe';
import BurgerMenuService from '../services/burger-menu.service';

Vue.directive('show-burger-menu', {
    bind(el: Element) {
        const burgerMenuService: BurgerMenuService = container.resolve(BurgerMenuService);
        burgerMenuService.registerButton(el as HTMLElement);

        el.addEventListener('click', () => {
            burgerMenuService.show();
        });
    }
});
