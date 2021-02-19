<style lang="scss" scoped src="./TotalOccupancy.scss"></style>
<script lang="ts" src="./TotalOccupancy.ts"></script>

<template>
    <div class="total-occupancy">
        <div class="header">
            <div class="left">
                <div class="date">{{ date.format('dd DD MMM') }}</div>
                <div class="percentages" v-if="occupancy">
                    <span class="percentage">
                        <span class="value">{{ Math.round(occupancy.avg) }}%</span> Durchschnitt
                    </span>,
                    <span class="percentage">
                        <span class="value">{{ Math.round(occupancy.min) }}%</span> Tiefstwert
                    </span>,
                    <span class="percentage">
                        <span class="value">{{ Math.round(occupancy.max) }}%</span> Höchstwert
                    </span>
                </div>
            </div>

            <div class="right">
                <div class="title">Gesamtauslastung</div>
                <div class="occupancy-range-toggle">
                    <simple-toggle ref="rangeToggle" v-on:change="calculateOccupancyRate($event); $emit('ratechanged', $event)" :options="[
                        { value: 'day',   label: 'Heute' },
                        { value: 'week',  label: 'Woche' },
                        { value: 'month', label: 'Monat' },
                    ]"></simple-toggle>
                </div>
            </div>
        </div>

        <div class="chart-container">
            <canvas ref="chart" height="264" width="720" class="chart"></canvas>
        </div>
    </div>
</template>
