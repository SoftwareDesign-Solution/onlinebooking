import { singleton } from 'tsyringe';
import Notification from '../models/notification';
import axios from 'axios';

// @ts-ignore
import Toast from '../components/Toast/Toast';
import ToastService from './toast.service';

@singleton()
export default class NotificationsService {

    constructor(private toastService: ToastService) {
    }


    async getNotifications(): Promise<Notification[]> {
        return (await axios.get('/api/notifications')).data;
    }

    async markNotificationAsViewed(id: number): Promise<void> {
        return (await axios.post(`/api/notifications/${id}`)).data;
    }

    async deleteNotification(id: number): Promise<void> {
        return (await axios.delete(`/api/notifications/${id}`)).data;
    }

    createNotificationToast(message: string): Toast {
        const toast = this.toastService.createToast();

        toast.isNotificationToast = true;
        toast.message = message;

        return toast;
    }
}
