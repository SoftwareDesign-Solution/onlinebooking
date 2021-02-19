import OccupancyService from '../../services/occupancy.service';
import DateRangeService from '../../services/date-range.service';
import Component from 'vue-class-component';
import Vue from 'vue';
import chartConfig from './chart-config.json';
import { Chart } from 'chart.js';
import MathService from '../../services/math.service';
import moment, { Moment } from 'moment';

@Component
export default class TotalOccupancy extends Vue {

    occupancy = null;
    chart: Chart = null;
    date: Moment = moment.utc();

    private occupancyService: OccupancyService;
    private dateRangeService: DateRangeService;
    private mathService: MathService;

    $refs!: {
        rangeToggle: any,
        chart: HTMLCanvasElement
    }

    created() {
        this.occupancyService = this.$container.resolve(OccupancyService);
        this.dateRangeService = this.$container.resolve(DateRangeService);
        this.mathService = this.$container.resolve(MathService);
    }

    async mounted() {
        this.initializeChart();
        await this.calculateOccupancyRate();
    }

    initializeChart() {
        const ctx = this.$refs.chart.getContext('2d');
        this.chart = new Chart(ctx, chartConfig);
    }

    async calculateOccupancyRate() {
        const range = this.$refs.rangeToggle.value;
        const { from, to } = this.dateRangeService.createRange(range, this.date);

        const { labels, data } = range === 'day' ?
            await this.occupancyService.calculateHourlyOccupancy(from, to) :
            await this.occupancyService.calculateDailyOccupancy(from, to);

        this.updateChart(labels, data);
    }

    updateChart(labels, data) {
        this.chart.data.labels = labels;
        this.chart.data.datasets[0].data = data;
        this.chart.update();
        this.occupancy = {
            min: Math.min(...data),
            max: Math.max(...data),
            avg: this.mathService.average(data)
        }
    }

    setDate(date: Moment) {
        this.date = date;
        this.calculateOccupancyRate();
    }
}
