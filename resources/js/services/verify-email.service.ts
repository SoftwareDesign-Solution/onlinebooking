import { injectable } from 'tsyringe';
import Notification from '../models/notification';
import NotificationHandler from '../interfaces/notification-handler.interface';
import NotificationsService from './notifications.service';
import * as moment from 'moment';

@injectable()
export default class VerifyEmailService implements NotificationHandler {

    constructor(private notificationService: NotificationsService) {
    }

    canHandle(type: string): boolean {
        return type === Notification.TYPE_VERIFY_EMAIL;
    }

    handle(notification: Notification) {
        if (notification.last_displayed && moment().diff(moment(notification.last_displayed), 'day') === 0) {
            return;
        }

        const toast = this.notificationService.createNotificationToast('Bestätige deine E-Mail-Adresse, um die Registrierung abzuschließen und warte auf die Freischaltung deines Accounts.');

        toast.$on('hide', () => {
            this.notificationService.markNotificationAsViewed(notification.id);
        });

        toast.show();
    }
}
