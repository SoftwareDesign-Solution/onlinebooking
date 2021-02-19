<style scoped lang="scss" src="./OpeningHours.scss"></style>
<script lang="ts" src="./OpeningHours.ts"></script>

<template>
    <div class="opening-hours">
        <div class="header">
            <div class="title">Aktuelle Öffnungszeiten</div>
            <div class="opening-hours" v-if="hours">
                <div class="week-days">Mo-Fr {{ hours.weekday.from }}:00-{{ hours.weekday.to }}:00</div>
                <div class="week-ends">Sa-So {{ hours.weekend.from }}:00-{{ hours.weekend.to }}:00</div>
            </div>

            <div class="update-hours" v-if="hours">
                <div class="title">Neue Öffnungszeiten</div>
                <div class="hours">
                    Mo bis Fr von
                    <time-selector v-on:change="hours.weekday.from = $event" :min="11" :max="24" :initial="hours.weekday.from"></time-selector>
                    bis
                    <time-selector v-on:change="hours.weekday.to = $event" :min="11" :max="24" :initial="hours.weekday.to"></time-selector>
                </div>
                <div class="hours">
                    Sa bis So von
                    <time-selector v-on:change="hours.weekend.from = $event" :min="11" :max="24" :initial="hours.weekend.from"></time-selector>
                    bis
                    <time-selector v-on:change="hours.weekend.to = $event" :min="11" :max="24" :initial="hours.weekend.to"></time-selector>
                </div>
                <button type="button" v-on:click="saveOpeningHours()">Öffnungszeiten speichern</button>
            </div>
        </div>
    </div>
</template>
