import { injectAll, singleton } from 'tsyringe';
import NotificationHandler from '../interfaces/notification-handler.interface';
import NotificationsService from './notifications.service';
import Notification from '../models/notification';
import UsersService from './users.service';

@singleton()
export default class NotificationsManagerService {

    constructor(@injectAll('NotificationHandler') private handler: NotificationHandler[],
                private notificationsService: NotificationsService,
                private usersService: UsersService) {
    }

    async handleNotifications() {
        if (!await this.usersService.isAuthenticated()) {
            return;
        }

        const notifications = await this.notificationsService.getNotifications();

        this.handler.forEach(handler => {
            notifications.forEach(notification => {
                if (handler.canHandle(notification.type)) {
                    handler.handle(notification);
                }
            });
        })
    }

}
