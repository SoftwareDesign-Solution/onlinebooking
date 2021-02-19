import NotificationHandler from '../interfaces/notification-handler.interface';
import { injectable } from 'tsyringe';
import Notification from '../models/notification';
import NotificationsService from './notifications.service';

@injectable()
export default class PasswordChangedService implements NotificationHandler {

    constructor(private notificationService: NotificationsService) {
    }

    canHandle(type: string): boolean {
        return type === Notification.TYPE_PASSWORD_CHANGED;
    }

    handle(notification: Notification) {
        this.notificationService.createNotificationToast('Passwort erfolgreich geändert!').show();
        this.notificationService.deleteNotification(notification.id);
    }

}
