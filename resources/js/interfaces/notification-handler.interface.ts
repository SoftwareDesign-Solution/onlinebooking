import Notification from '../models/notification';

export default interface NotificationHandler {
    canHandle(type: string): boolean;
    handle(notification: Notification);
}
