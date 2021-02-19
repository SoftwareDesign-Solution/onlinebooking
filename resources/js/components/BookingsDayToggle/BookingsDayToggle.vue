<style lang="scss" src="./BookingsDayToggle.scss" scoped></style>
<script lang="ts" src="./BookingsDayToggle.ts"></script>

<template>
    <div class="calendar-day-toggle">
        <div class="day-arrow" v-on:click="prevDay()">
            <svg-vue icon="angle-left"></svg-vue>
        </div>

        <span class="date-label">{{ date.format('dd ll') }} <svg-vue icon="calendar-day"></svg-vue></span>

        <a class="day-arrow" v-on:click="nextDay()">
            <svg-vue icon="angle-right"></svg-vue>
        </a>
    </div>
</template>
