<style lang="scss" scoped src="./BookingDetails.scss"></style>
<script lang="ts" src="./BookingDetails.ts"></script>

<template>
    <div class="booking-details" v-on:click="openPopup()">
        <slot></slot>
        <popup ref="popup">
            <div class="booking-popup-content">
                <template v-if="booking == null">
                    loading...
                </template>
                <template v-if="booking != null">
                    <div class="close" v-on:click="closePopup()">
                        <svg-vue class="close-button" icon="times"></svg-vue>
                    </div>

                    <h2>Buchung</h2>
                    <div class="date">{{ $moment.utc(booking.from).format('dd D MMM &nbsp;&nbsp;HH : 00') }} - {{ $moment.utc(booking.to).format('HH : 00') }}</div>

                    <p>Proberaum: {{ booking.room.name }}</p>
                    <p>Termin: {{ $moment.utc(booking.from).format('dd D MMM &nbsp;&nbsp;HH : 00') }} - {{ $moment.utc(booking.to).format('HH : 00') }}</p>
                    <p>Name: {{ booking.user.name }}</p>
                    <p>E-Mail-Adresse: {{ booking.user.email }}</p>
                    <p>Telefonnummer: {{ booking.user.phone }}</p>
                    <p>Buchungsnotiz: {{ booking.notes || 'keine' }}</p>

                    <button v-on:click="deleteBooking(booking)">Termin löschen</button>
                </template>
            </div>
        </popup>
    </div>
</template>
