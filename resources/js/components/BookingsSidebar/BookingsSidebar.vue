<style lang="scss" src="./BookingsSidebar.scss" scoped></style>
<script lang="ts" src="./BookingsSidebar.ts"></script>

<template>
    <div class="booking-sidebar-content">
        <date-picker
            v-model="dateInput"
            v-on:input="checkVacationBooking(); $emit('datechange',  $moment.utc(dateInput.start))"
            :color="'var(--color-primary)'"
            :no-keyboard="true"
            :range="true"
            :no-shortcuts="true"
            :no-button="true"
            :min-date="$moment.utc().format('YYYY-MM-DD')"
            format="YYYY-MM-DD"
            :locale="'de_DE'"
            :no-header="true"
            :inline="true"
            :only-date="true">
        </date-picker>
        <hr/>
        <div class="scroll-container">
            <div class="special-booking-header">
                <div class="selected-date-range">
                    <template v-if="dateInput">
                        {{ $moment.utc(dateInput.start).format('dd D MMM') }}
                        <template v-if="dateInput.end"> - {{ $moment.utc(dateInput.end).format('dd D MMM') }}</template>
                    </template>
                </div>
                <div class="special-booking-type-selector">
                    <div class="special-booking-type-label">Sonderbuchung</div>
                    <div class="special-booking-type-buttons">
                        <div class="special-booking-type" v-bind:class="{ 'active': specialBookingType === 'ahead' }"
                             v-on:click="specialBookingType = 'ahead'">
                            Vorraus
                        </div>
                        <div class="special-booking-type" v-bind:class="{ 'active': specialBookingType === 'vacation' }"
                             v-on:click="specialBookingType = 'vacation'">
                            Urlaub
                        </div>
                    </div>
                </div>
            </div>

            <template v-if="specialBookingType === 'vacation'">
                <template v-if="hasVacationBooked">
                    <button type="button" v-on:click="deleteVacation()" class="disabled">Urlaub bereits gebucht</button>
                </template>
                <template v-if="!hasVacationBooked">
                    <button type="button" v-on:click="bookVacation()">Urlaub buchen</button>
                </template>
            </template>

            <template v-if="specialBookingType === 'ahead'">
                <div class="row">
                    <div class="col-6">
                        <label>&nbsp;</label>
                        <time-selector ref="hourFromInput" :initial="11"></time-selector>
                        bis
                        <time-selector ref="hourToInput" :initial="12"></time-selector>
                    </div>

                    <div class="col-6">
                        <label>Proberaum</label>
                        <styled-select ref="roomInput">
                            <template v-if="rooms">
                                <option v-for="room of rooms" v-bind:value="room.id">{{ room.name }}</option>
                            </template>
                        </styled-select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <label>Name</label>
                        <input type="text" v-model="bookingModel.name" v-on:focusin="$refs.nameAutoSuggest.visible = true" v-on:focusout="$refs.nameAutoSuggest.setVisible(false)">
                        <auto-suggest ref="nameAutoSuggest" v-model="bookingModel.name" v-on:change="selectUserSuggestion" :suggest="suggestUsers">
                            <template v-slot:default="slotProps">{{ slotProps.suggestion.name }}</template>
                        </auto-suggest>
                    </div>
                    <div class="col-6">
                        <label>Wiederkehrende Buchung</label>
                        <div class="repeat-booking">
                            <input ref="repeatCheckBox" type="checkbox" v-on:change="repeatBooking = !repeatBooking">
                            <template v-if="repeatBooking">
                                Wochen: <input v-model="repetitions" id="repeatInput" type="number" ref="repeatInput">
                            </template>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <label>Telefonnummer</label>
                        <input type="text" v-model="bookingModel.phone" v-on:focusin="$refs.phoneAutoSuggest.visible = true" v-on:focusout="$refs.phoneAutoSuggest.setVisible(false)">
                        <auto-suggest ref="phoneAutoSuggest" v-model="bookingModel.phone" v-on:change="selectUserSuggestion" :suggest="suggestUsers">
                            <template v-slot:default="slotProps">{{ slotProps.suggestion.phone }}</template>
                        </auto-suggest>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="textarea-container">
                            <label>Buchungsnotiz:</label>
                            <textarea cols="4" v-model="bookingModel.notes"></textarea>
                        </div>
                    </div>
                </div>

                <button type="button" v-on:click="bookAhead()">Vorraus buchen</button>
            </template>
        </div>
    </div>
</template>
