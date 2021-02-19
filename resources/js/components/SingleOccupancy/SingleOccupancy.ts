import OccupancyService from '../../services/occupancy.service';
import DateRangeService from '../../services/date-range.service';
import Component from 'vue-class-component';
import Vue from 'vue';
import * as Chart from 'chart.js';
import chartConfig from './chart-config.json';
import moment, { Moment } from 'moment';

enum OccupancyRange {
    Day = 'day',
    Week = 'week',
    Month = 'month',
}

@Component
export default class SingleOccupancy extends Vue {
    range: OccupancyRange = OccupancyRange.Day;
    date: Moment = moment.utc();

    private chart: Chart;

    private occupancyService: OccupancyService;
    private dateRangeService: DateRangeService;

    $refs!: {
        chart: HTMLCanvasElement
    }

    created() {
        this.occupancyService = this.$container.resolve(OccupancyService);
        this.dateRangeService = this.$container.resolve(DateRangeService);
    }

    mounted() {
        this.initializeChart();
        this.calculateSingleOccupancy();
    }

    calculateBorderColor(context) {
        const index = context.dataIndex;
        const value = context.dataset.data[index];

        return value === Math.max(...context.dataset.data) ? '#ED7B23' : '#FCFCFC';
    }

    initializeChart() {
        const ctx = this.$refs.chart.getContext('2d');

        const config = Object.assign({}, chartConfig);
        config.data.datasets[0].borderColor = this.calculateBorderColor as any;

        this.chart = new Chart(ctx, config);
    }

    updateChart(labels, data) {
        this.chart.data.labels = labels;
        this.chart.data.datasets[0].data = data;
        this.chart.update();
    }

    setRange(range) {
        this.range = range;
        this.calculateSingleOccupancy();
    }

    async calculateSingleOccupancy() {
        const { from, to } = this.dateRangeService.createRange(this.range, this.date);
        const { labels, data } = await this.occupancyService.calculateRoomOccupancy(from, to);

        this.updateChart(labels, data);
    }

    setDate(date: Moment) {
        this.date = date;
        this.calculateSingleOccupancy();
    }
}
