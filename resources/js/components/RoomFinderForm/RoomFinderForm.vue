<style lang="scss" scoped src="./RoomFinderForm.scss"></style>
<script lang="ts" src="./RoomFinderForm.ts"></script>

<template>
    <div class="room-finder" v-bind:class="{ 'single-date': type === 'single', 'multi-date': type === 'multiple' }">
        <simple-toggle ref="typeToggle"
                       v-on:change="type = $event"
                       :options="[{ value: 'single', label: 'Einzeltermin' }, { value: 'multiple', label: 'Zeitraum' }]">
        </simple-toggle>
        <popup-button-input ref="roomsPopupButton" v-on:click="$refs.roomsPopup.show()" label="Proberäume">
            <template v-if="selectedRooms.length === 0">
                Keine ausgewählt
            </template>
            <template v-if="selectedRooms.length === 1">
                {{ selectedRooms[0].name }} ausgewählt.
            </template>
            <template v-if="selectedRooms.length > 1 && selectedRooms.length < rooms.length">
                {{ selectedRooms.slice(0).reverse().slice(1).reverse().map(room => room.name).join(", ") }} und {{ selectedRooms.slice(0).reverse()[0].name }} ausgewählt.
            </template>
            <template v-if="selectedRooms.length === rooms.length">
                alle ausgewählt
            </template>
        </popup-button-input>
        <div class="row">
            <div class="col-6">
                <popup-button-input v-on:click="$refs.datePopup.show()" label="Datum">
                    <template v-if="selectedDate">
                        <span class="weekday">{{ selectedDate.from.format("dd") }}</span> {{ selectedDate.from.format("DD MMM") }}
                        <template v-if="selectedDate.to">
                            <span class="selected-date-to">
                                – <span class="weekday">{{ selectedDate.to.format("dd") }}</span> {{ selectedDate.to.format("DD MMM") }}
                            </span>
                        </template>
                    </template>
                    <template v-if="!selectedDate">
                        –
                    </template>
                </popup-button-input>
            </div>
            <div class="col-6">
                <popup-button-input v-on:click="$refs.timePopup.show()" label="Uhrzeit">
                    <template v-if="selectedTime">
                        {{ `${selectedTime.from}`.padStart(2, '0') }}:00
                        -
                        {{ `${selectedTime.to}`.padStart(2, '0') }}:00
                    </template>
                    <template v-if="!selectedTime">–</template>
                </popup-button-input>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <form method="POST" action="/bookings">
                    <slot></slot>
                    <template v-if="selectedDate">
                        <!-- .toISOString() YYYY-MM-DD-->
                        <input type="hidden" name="dateFrom" v-bind:value="selectedDate.from.format(this.$config.date_format)">
                        <input v-if="selectedDate.to && type === 'multiple'" type="hidden" name="dateTo" v-bind:value="selectedDate.to.format(this.$config.date_format)">
                    </template>
                    <template v-if="selectedTime">
                        <input type="hidden" name="hourFrom" v-bind:value="selectedTime.from">
                        <input type="hidden" name="hourTo" v-bind:value="selectedTime.to">
                    </template>
                    <input type="hidden" name="rooms" v-bind:value="selectedRooms.map(room => room.id).join(',')">
                    <button type="submit">{{ isAuthenticated ? "Termin suchen" : "Zuerst anmelden" }}</button>
                </form>
            </div>
        </div>

        <popup ref="roomsPopup" class="rooms-popup">
            <rooms-popup v-on:select="selectedRooms = $event.slice(0)"></rooms-popup>
        </popup>

        <popup ref="datePopup" class="date-popup">
            <date-popup v-on:select="selectedDate = $event; $refs.typeToggle.value = type = $event.to ? 'multiple' : 'single'"></date-popup>
        </popup>

        <popup ref="timePopup" class="time-popup">
            <time-popup v-on:select="selectedTime = $event"></time-popup>
        </popup>
    </div>
</template>

