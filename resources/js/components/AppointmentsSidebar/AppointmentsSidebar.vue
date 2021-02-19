<script lang="ts" src="./AppointmentsSidebar.ts"></script>
<style lang="scss" src="./AppointmentsSidebar.scss" scoped></style>

<template>
    <div class="appointments-content">
        <date-picker
            v-model="dateInput"
            v-on:input="loadAppointments(); $emit('datechange', $moment.utc($event))"
            :color="'var(--color-primary)'"
            :no-keyboard="true"
            :range="false"
            :no-shortcuts="true"
            :no-button="true"
            :locale="'de_DE'"
            :no-header="true"
            :inline="true"
            :only-date="true">
        </date-picker>
        <hr/>

        <div class="appointments-header">
            <div class="selected-date">
                <div class="date">
                    <template v-if="dateInput">
                        {{ $moment.utc(dateInput.start).format('dd D MMM') }}
                    </template>
                </div>
                <div class="appointment-count">
                    <template v-if="appointments">
                        {{ appointments.length }} Termine insgesamt
                    </template>
                </div>
            </div>

            <div class="view-type-selector">
                <div class="view-type-label">Terminübersicht</div>
                <div class="view-type-buttons">
                    <div class="view-type" v-bind:class="{ 'active': viewType === 'time' }"
                         v-on:click="viewType = 'time'; sortAppointments()">
                        Zeit
                    </div>
                    <div class="view-type" v-bind:class="{ 'active': viewType === 'room' }"
                         v-on:click="viewType = 'room'; sortAppointments()">
                        Proberaum
                    </div>
                </div>
            </div>
        </div>

        <div class="scroll-container">
            <div class="appointments">
                <template v-if="!appointments">
                    loading...
                </template>
                <template v-if="appointments">
                    <div v-for="appointment of appointments" class="appointment">
                        <div class="appointment-header">
                            <div class="user"><svg-vue icon="user"></svg-vue> {{ appointment.name }}</div>
                            <div class="time">{{ $moment.utc(appointment.from).hour() }} : 00 – {{ $moment.utc(appointment.to).hour() }} : 00</div>
                            <div class="room">{{ appointment.room }}</div>
                        </div>
                        <div class="notes">
                            {{ appointment.notes || 'Keine Buchungsnotiz' }}
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</template>

