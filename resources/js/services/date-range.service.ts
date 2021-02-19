import * as moment from 'moment';
import { injectable } from 'tsyringe';
import { Moment } from 'moment';

@injectable()
export default class DateRangeService {

    createRange(unit: 'day' | 'week' | 'month', relativeTo?: string | Moment): { from: string, to: string } {
        return {
            from: moment.utc(relativeTo).startOf(unit).toISOString(),
            to: moment.utc(relativeTo).endOf(unit).toISOString()
        }
    }

}
