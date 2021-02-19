<style lang="scss" scoped src="./BookingsTable.scss"></style>
<script lang="ts" src="./BookingsTable.ts"></script>

<template>
    <div class="bookings-table-container">
        <div v-if="!loaded" class="loading-spinner">
            loading...
        </div>
        <table v-if="loaded" class="bookings-table">
            <tr>
                <th></th>
                <th v-for="room of rooms">{{ room.name }}</th>
            </tr>

            <template v-if="hasVacationBooked">
                <tr v-for="slot of hourSlots">
                    <td class="slot-label">{{ slot }} : 00</td>
                    <td v-if="hourSlots[0] === slot" class="vacation" v-bind:rowspan="hourSlots.length" v-bind:colspan="rooms.length">Urlaub</td>
                </tr>
            </template>

            <template v-if="!hasVacationBooked">
                <tr v-for="slot of hourSlots">
                    <td class="slot-label">{{ slot }} : 00</td>
                    <template v-for="room of rooms">
                        <td v-on:click="openBookingPopup(room, slot)" v-if="isBooked(room, slot)" class="booked">
                            {{ getBooking(room, slot).user.name }}
                        </td>
                        <td v-if="!isBooked(room, slot)" class="open" v-on:click="$emit('slotselected', { date, room, slot })">
                            {{ room.rate }} €
                        </td>
                    </template>
                </tr>
            </template>

            <popup ref="bookingPopup" class="booking-popup">
                <popup-close-button></popup-close-button>
                <template v-if="selectedBooking">
                    <h2 v-if="selectedBooking.type === 'regular'">Buchung</h2>
                    <h2 v-if="selectedBooking.type === 'special'">Vorausbuchung</h2>
                    <div class="date">
                        {{ selectedBooking.from.format('dd DD MM') }} {{ selectedBooking.from.hour() }} : 00 – {{ selectedBooking.to.hour() }} : 00
                    </div>

                    <div class="info">
                        <p>Proberaum: {{ selectedBooking.room.name }}</p>
                        <p>Termin: {{ selectedBooking.from.format('dd DD MM') }} {{ selectedBooking.from.hour() }} : 00 – {{ selectedBooking.to.hour() }} : 00</p>
                        <p>Name: {{ selectedBooking.user.name }}</p>
                        <p v-if="selectedBooking.user.email">E-Mail-Adresse: {{ selectedBooking.user.email }}</p>
                        <p v-if="selectedBooking.user.phone">Telefonnummer: {{ selectedBooking.user.phone }}</p>
                        <p>Buchungsnotiz: <template v-if="!selectedBooking.notes">keine</template>{{ selectedBooking.notes }}</p>
                    </div>

                    <button v-on:click="deleteBooking(selectedBooking)">Termin löschen</button>
                </template>
            </popup>
        </table>
    </div>
</template>
