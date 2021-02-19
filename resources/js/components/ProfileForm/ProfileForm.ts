import Vue from 'vue';
import Component from 'vue-class-component';
import UsersService from '../../services/users.service';
import User from '../../models/user';

@Component
export default class ProfileForm extends Vue {

    user: User = null;
    isFormEnabled: boolean = false;
    errors: { [key: string]: string[] } = null;

    private usersService: UsersService;

    async created() {
        this.usersService = this.$container.resolve(UsersService);

        this.user = await this.usersService.loadCurrentUser();
    }

    async toggleForm() {
        const previousState = this.isFormEnabled;
        this.isFormEnabled = false;
        if (previousState === true) {
            await this.updateUser();
        }
        this.isFormEnabled = !!this.errors ? true : !previousState;
    }

    private async updateUser() {
        this.errors = null;
        try {
            const changes = await this.calculateChanges();
            this.user = await this.usersService.patchCurrentUser(changes);
        } catch (e) {
            if (e.response.status === 422) {
                this.errors = e.response.data.errors;
            }
        }
    }

    private async calculateChanges(): Promise<Partial<User>> {
        const user = await this.usersService.loadCurrentUser();
        const changes: Partial<User> = {};
        for(const key of ["name", "phone", "email"]) {
            if (user[key] !== this.user[key]) {
                changes[key] = this.user[key];
            }
        }
        return changes;
    }

    isInvalid(name: string): boolean {
        return this.errors && !!this.errors[name];
    }

    async deleteAccount() {
        await this.usersService.deleteCurrentUser();
        location.href = "/";
    }

}
