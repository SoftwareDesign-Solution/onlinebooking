import { singleton } from 'tsyringe';

interface Popup {
    name?: string;
    open: boolean;
    show(): void;
    hide(): void;
    focus(): void;
}

@singleton()
export default class PopupService {

    private container: Element;
    private popups: Popup[] = [];

    currentPopup: Popup = null;

    createPopupContainer(selector = 'body'): Element {
        if (!this.container) {
            this.container = document.createElement('div');
            this.container.setAttribute('class', 'popup-container');
            document.querySelector(selector).appendChild(this.container);
        }

        return this.container;
    }

    register(popup: Popup) {
        this.popups.push(popup);
    }

    showPopup(popup: Popup) {
        this.hideCurrentPopup();
        this.currentPopup = popup;
        popup.open = true;
        popup.focus();
        this.container.classList.add('open');
    }

    showPopupByName(name: string) {
        const popup = this.popups.filter(popup => popup.name === name)[0];
        if (!popup) {
            return;
        }
        this.showPopup(popup);
    }

    hideCurrentPopup() {
        if (!this.currentPopup) {
            return;
        }

        this.currentPopup.open = false;
        this.currentPopup = null;
        this.container.classList.remove('open');
    }

    get isPopupOpen(): boolean {
        return !!this.currentPopup;
    }

}
