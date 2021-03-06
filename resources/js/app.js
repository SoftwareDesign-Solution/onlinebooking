import "reflect-metadata";
import SvgVue from 'svg-vue';
import VueCtkDateTimePicker from 'vue-ctk-date-time-picker';
import 'vue-ctk-date-time-picker/dist/vue-ctk-date-time-picker.css';
import {container} from "tsyringe";
import moment from 'moment';
import {AppRegistry} from "./registry";
import './bootstrap';
import PopupService from "./services/popup.service";
import NotificationsManagerService from "./services/notifications-manager.service";

new AppRegistry();
window.Vue = require('vue');

Vue.use(SvgVue);
Vue.component('date-picker', VueCtkDateTimePicker);

const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

require('./directives/ShowPopupDirective');
require('./directives/ShowBurgerMenuDirective');
require('./directives/HideBurgerMenuDirective');

moment.locale('de_DE');
moment.suppressDeprecationWarnings = true;
Object.defineProperty(Vue.prototype, '$moment', {value: moment});
Object.defineProperty(Vue.prototype, '$container', {value: container});
Object.defineProperty(Vue.prototype, '$closePopup', {
    value: () => {
        container.resolve(PopupService).hideCurrentPopup();
    }
});

window.OnlineBooking = {
    generalInformation: JSON.parse(document.querySelector('#static-general-information').textContent),
    rooms: JSON.parse(document.querySelector('#static-rooms').textContent)
}

// Config
Object.defineProperty(Vue.prototype, '$config', {
    value: {
        date_format: 'DD-MM-YY',
        date_displayformat: ''
    }
});

new Vue({
    el: '#app',
    data: {
        notificationsManager: container.resolve(NotificationsManagerService)
    },
    async mounted() {
        document.querySelector('#app').classList.add('mounted');
        await this.notificationsManager.handleNotifications();
    }
});
