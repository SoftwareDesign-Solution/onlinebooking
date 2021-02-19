import Vue from 'vue';
import Component from 'vue-class-component';
import ToastService from '../../services/toast.service';

const ToastProps = Vue.extend({
    props: {
        container: String,
        name: String,
        showOnMount: Boolean
    }
})

@Component
export default class Toast extends ToastProps {
    toastContainer: Element = null;
    open: boolean = false;

    isNotificationToast: boolean = false;
    message: string = null;

    private toastService: ToastService;

    created() {
        this.toastService = this.$container.resolve(ToastService);
        this.toastContainer = this.toastService.createToastContainer(this.container);
        this.toastService.register(this);
    }

    mounted() {
        this.toastContainer.appendChild(this.$el);
        if (this.showOnMount) {
            this.show();
        }
    }

    show() {
        this.toastService.showToast(this);
        this.$emit('show');
    }

    hide() {
        this.toastService.hideCurrentToast();
        this.$emit('hide');
    }

}

