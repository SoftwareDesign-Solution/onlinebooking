<style lang="scss" scoped src="./SingleOccupancy.scss"></style>
<script lang="ts" src="./SingleOccupancy.ts"></script>

<template>
    <div class="single-occupancy">
        <div class="header">
            <div class="title">
                Einzelauslastung
            </div>
            <div class="range">
                <template v-if="range === 'day'">Heute</template>
                <template v-if="range === 'week'">Woche</template>
                <template v-if="range === 'month'">Monat</template>
            </div>
        </div>

        <div class="chart-container">
            <canvas ref="chart" class="chart" height="180"></canvas>
        </div>
    </div>
</template>
