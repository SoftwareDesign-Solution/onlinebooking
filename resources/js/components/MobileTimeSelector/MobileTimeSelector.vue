<style lang="scss" scoped src="./MobileTimeSelector.scss"></style>
<script lang="ts" src="./MobileTimeSelector.ts"></script>

<template>
    <div class="mobile-time-selector">
        <div class="mask" v-bind:class="{ 'loaded': loaded }">
            <div ref="hoursFrom" class="hours">
                <div v-for="hour of hours" class="hour">
                    {{ `${hour}`.padStart(2, '0') }} : 00
                </div>
            </div>
            <div class="divider">
                –
            </div>
            <div ref="hoursTo" class="hours">
                <div v-for="hour of hours" class="hour">
                    {{ `${hour}`.padStart(2, '0') }} : 00
                </div>
            </div>
        </div>
    </div>
</template>
