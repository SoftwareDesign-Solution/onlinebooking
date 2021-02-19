import { injectable } from 'tsyringe';
import GeneralInformation from '../models/general-information';
import axios from 'axios';

@injectable()
export default class GeneralInfoService {

    async loadGeneralInfo(): Promise<GeneralInformation> {
        return window.OnlineBooking.generalInformation;
    }

    async patchGeneralInfo(patch: Partial<GeneralInformation>): Promise<void> {
        await axios.patch('/api/general', patch);
    }

}
