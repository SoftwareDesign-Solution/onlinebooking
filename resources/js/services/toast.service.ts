import { singleton } from 'tsyringe';

// @ts-ignore
import Toast from '../components/Toast/Toast';
import Vue from 'vue';

@singleton()
export default class ToastService {

    private container: Element;
    private toasts: Toast[] = [];

    currentToast: Toast = null;

    createToastContainer(selector = 'body'): Element {
        if (!this.container) {
            this.container = document.createElement('div');
            this.container.setAttribute('class', 'toast-container');
            document.querySelector(selector).appendChild(this.container);
        }

        return this.container;
    }

    createToast(): Toast {
        const instance = new (Vue.extend(Toast));
        instance.$mount();
        this.container.appendChild(instance.$el);
        return instance as Toast;
    }

    register(toast: Toast) {
        this.toasts.push(toast);
    }

    showToast(toast: Toast) {
        this.hideCurrentToast();
        this.currentToast = toast;
        toast.open = true;
        this.container.classList.add('open');
    }

    showToastByName(name: string) {
        const toast = this.toasts.filter(toast => toast.name === name)[0];
        if (!toast) {
            return;
        }
        this.showToast(toast);
    }

    hideCurrentToast() {
        if (!this.currentToast) {
            return;
        }

        this.currentToast.open = false;
        this.currentToast = null;
        this.container.classList.remove('open');
    }

    get isToastOpen(): boolean {
        return !!this.currentToast;
    }

}
