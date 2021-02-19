import Vue from 'vue';
import Component from 'vue-class-component';
import * as Hammer from 'hammerjs';
import GeneralInfoService from '../../services/general-info.service';

const MobileTimeSelectorProps = Vue.extend({
    props: {
        initialFrom: Number,
        initialTo: Number
    }
});

@Component
export default class MobileTimeSelector extends MobileTimeSelectorProps {

    hours: number[] = new Array(24).fill(1).map((_, i) => i + 1);

    value: { from: number, to: number } = { from: 1, to: 1 }

    $refs!: {
        hoursFrom: HTMLDivElement,
        hoursTo: HTMLDivElement,
    }

    loaded: boolean = false;

    private generalInfoService: GeneralInfoService;
    private minHour: number;
    private maxHour: number;
    private isMounted: boolean = false;

    async created() {
        this.generalInfoService = await this.$container.resolve(GeneralInfoService);
        const generalInfo = await this.generalInfoService.loadGeneralInfo();
        this.minHour = Math.min(generalInfo.opening_hours_start_weekdays, generalInfo.opening_hours_start_weekend);
        this.maxHour = Math.max(generalInfo.opening_hours_end_weekdays, generalInfo.opening_hours_end_weekend);
        this.value.from = this.initialFrom || this.minHour;
        this.value.to = this.initialTo || this.maxHour;
        this.updateHours();
        this.loaded = true;
        if (this.isMounted) {
            this.snapToValue(this.$refs.hoursFrom, this.hours.indexOf(this.value.from) + 1);
            this.snapToValue(this.$refs.hoursTo, this.hours.indexOf(this.value.to) + 1);
        }
    }

    mounted() {
        this.registerPanEvents(this.$refs.hoursFrom);
        this.registerPanEvents(this.$refs.hoursTo);

        if (this.loaded) {
            this.snapToValue(this.$refs.hoursFrom, this.hours.indexOf(this.value.from) + 1);
            this.snapToValue(this.$refs.hoursTo, this.hours.indexOf(this.value.to) + 1);
        }

        this.$refs.hoursFrom.oninput = (hour: any) => {
            this.value.from = hour;
            this.$emit('change', this.value);
        };

        this.$refs.hoursTo.oninput = (hour: any) => {
            this.value.to = hour;
            this.$emit('change', this.value);
        };

        this.isMounted = true;
    }

    snapToValue(element: HTMLDivElement, value: number) {
        element.style.setProperty('--offset-y', `${-60 * (value - 1)}`);
    }

    onPan(event: HammerInput, element: HTMLDivElement) {
        element.style.setProperty('--delta-y', `${event.deltaY}`);
    }

    onPanEnd(event: HammerInput, element: HTMLDivElement) {
        element.style.setProperty('--delta-y', `0`);
        const previousOffset = parseInt(element.style.getPropertyValue('--offset-y')) || 0;
        element.style.setProperty('--offset-y', `${previousOffset + event.deltaY}`);
        element.style.setProperty('transition', '200ms ease');
        const snappedOffset = this.calculateSnappedOffset(previousOffset, event.deltaY);
        element.oninput(this.calculateSelectedHourFromOffset(snappedOffset) as any);
        setTimeout(() => {
            element.style.setProperty('--offset-y', `${snappedOffset}`);
        });
        setTimeout(() => {
            element.style.setProperty('transition', 'none');
        }, 200);
    }

    calculateSelectedHourFromOffset(offset: number): number {
        return this.hours[-offset / 60];
    }

    calculateSnappedOffset(previousOffset: number, deltaY: number): number {
        let snappedOffset = Math.round((previousOffset + deltaY) / 60.0) * 60;
        if (snappedOffset > 0) {
            return  0;
        }
        if (snappedOffset < -(this.hours.length - 1) * 60) {
            return -(this.hours.length - 1) * 60;
        }
        return snappedOffset;
    }

    registerPanEvents(element: HTMLDivElement) {
        const mc = new Hammer.Manager(element);
        const pan = new Hammer.Pan({
            direction: Hammer.DIRECTION_VERTICAL
        });
        mc.add(pan);
        mc.on('pan', (e) => {
            this.onPan(e, element);
        });

        mc.on('panend', (e) => {
            this.onPanEnd(e, element);
        });
    }

    private updateHours() {
        this.hours = Array(this.maxHour - this.minHour + 1).fill(1).map((_, i) => i + this.minHour);
    }

}
