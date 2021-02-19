export default class Notification {

    static TYPE_VERIFY_EMAIL = 'VERIFY_EMAIL';
    static TYPE_PASSWORD_CHANGED = 'PASSWORD_CHANGED'

    id: number;
    created_at: string;
    updated_at: string;

    content?: string;
    type: string;
    last_displayed: string;
    user_id: number;
}
