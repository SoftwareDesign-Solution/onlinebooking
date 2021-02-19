import axios from 'axios';
import User from '../models/user';
import { injectable } from 'tsyringe';

@injectable()
export default class UsersService {

    async loadAllUsers(): Promise<User[]> {
        return (await axios.get(`/api/users`)).data;
    }

    async searchUsers(query: string): Promise<User[]> {
        return (await axios.get(`/api/users`, {
            params: { query }
        })).data;
    }

    async loadUser(id: number): Promise<User> {
        return (await axios.get(`/api/users/${id}`)).data;
    }

    async loadCurrentUser(): Promise<User> {
        return (await axios.get('/api/users/me')).data;
    }

    async patchCurrentUser(data: Partial<User>): Promise<User> {
        return (await axios.patch('/api/users/me', data)).data;
    }

    async deleteCurrentUser(): Promise<void> {
        await axios.delete('/api/users/me');
    }

    async isAuthenticated(): Promise<boolean> {
        return document.querySelector('meta[name=logged-in]').getAttribute('content') === 'yes';
    }

}
