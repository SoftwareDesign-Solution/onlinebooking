import { singleton } from 'tsyringe';

@singleton()
export default class BurgerMenuService {

    private burgerMenuButtons: HTMLElement[] = [];

    registerButton(button: HTMLElement) {
        this.burgerMenuButtons.push(button);
    }

    show() {
        getApp().classList.add('burger-menu-open');
        getBurgerMenu().classList.add('active');
        this.burgerMenuButtons.forEach(button => button.classList.add('active'));
    }

    hide() {
        getApp().classList.remove('burger-menu-open');
        getBurgerMenu().classList.remove('active');
        this.burgerMenuButtons.forEach(button => button.classList.remove('active'));
    }

}

function getBurgerMenu(): HTMLElement {
    return document.querySelector('#burger-menu');
}

function getApp(): HTMLElement {
    return document.querySelector('#app');
}
