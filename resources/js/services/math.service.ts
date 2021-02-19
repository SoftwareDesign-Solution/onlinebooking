import { injectable } from 'tsyringe';

@injectable()
export default class MathService {
    average(array: number[]): number {
        if (array.length === 0) {
            return 0;
        }

        return array.reduce((prev, current) => prev + current) / array.length;
    }
}
