import { registry } from 'tsyringe';
import NotificationHandler from './interfaces/notification-handler.interface';
import VerifyEmailService from './services/verify-email.service';
import NotificationsManagerService from './services/notifications-manager.service';
import PasswordChangedService from './services/password-changed.service';

@registry([
    { token: 'NotificationHandler', useClass: VerifyEmailService },
    { token: 'NotificationHandler', useClass: PasswordChangedService },
    { token: NotificationsManagerService, useClass: NotificationsManagerService }
])
export class AppRegistry {
}
