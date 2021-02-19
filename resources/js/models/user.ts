export default class User {
    id: number;
    created_at: string;
    updated_at: string;

    name: string;
    email: string;
    email_verified_at: string;
    role: "user" | "admin";
    phone: string;
    active: boolean;
}
