<style lang="scss" scoped src="./TimePopup.scss"></style>
<script lang="ts" src="./TimePopup.ts"></script>

<template>
    <div class="time-popup-content container">
        <popup-close-button></popup-close-button>
        <div class="dialog-text">
            <h4>Beachte die Öffnungszeiten</h4>
            <div v-if="openingHours" class="opening-hours">
                Mo bis Fr von {{ `${openingHours.weekdays.start}`.padStart(2, '0') }}:00 bis {{ `${openingHours.weekdays.end}`.padStart(2, '0') }}:00<br/>
                Sa und So von {{ `${openingHours.weekend.start}`.padStart(2, '0') }}:00 bis {{ `${openingHours.weekend.end}`.padStart(2, '0') }}:00
            </div>
        </div>
        <div class="select-time">Tägliche Uhrzeit wählen</div>
        <mobile-time-selector v-on:change="value = $event"></mobile-time-selector>
        <div class="desktop-time-selector" v-if="min && max">
            <time-selector :initial="min" :min="min" :max="value.to" v-on:change="value.from = $event"></time-selector> bis
            <time-selector :initial="max" :min="value.from" :max="max" v-on:change="value.to = $event"></time-selector>
        </div>
        <button type="button" v-on:click="onTimeSelected()">Uhrzeit auswählen</button>
    </div>
</template>
