<style lang="scss" scoped src="./BookRoomForm.scss"></style>
<script lang="ts" src="./BookRoomForm.ts"></script>

<template>
    <div class="book-room-form">
        <div class="hours" v-if="value">
            <div class="time-selector-desktop">
                <time-selector v-on:change="value.from = $event; $emit('change', value)" :min="minHour"    :max="value.to" :initial="hourFrom"></time-selector> –
                <time-selector v-on:change="value.to = $event; $emit('change', value)"   :min="value.from" :max="maxHour"  :initial="hourTo"></time-selector>
            </div>
            <mobile-time-selector v-on:change="value.from = $event.from; value.to = $event.to; $emit('change', $event)"
                                  :initial-from="hourFrom"
                                  :initial-to="hourTo"></mobile-time-selector>
        </div>
    </div>
</template>
