import DependencyContainer from 'tsyringe/dist/typings/types/dependency-container';
import GeneralInformation from '../../js/models/general-information';
import Room from '../../js/models/room';

declare module 'vue/types/vue' {
    interface VueConstructor {
    }

    interface Vue {
        $container: DependencyContainer;
    }
}

declare global {
    interface Window {
        OnlineBooking: {
            generalInformation: GeneralInformation
            rooms: Room[]
        }
    }
}
