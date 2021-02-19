<style lang="scss" src="./DatePopup.scss" scoped></style>
<script lang="ts" src="./DatePopup.ts"></script>

<template>
    <div class="date-popup-content container">
        <popup-close-button></popup-close-button>
        <div class="date-picker">
            <date-picker
                v-model="rawModel"
                v-on:input="transformRawModel(); checkVacationBooking()"
                :color="'var(--color-primary)'"
                :no-keyboard="true"
                :range="true"
                :no-shortcuts="true"
                :min-date="$moment.utc().format('YYYY-MM-DD')"
                :no-button="true"
                :locale="'de_DE'"
                :no-header="true"
                :inline="true"
                :only-date="true">
            </date-picker>
        </div>
        <div class="dialog-text">
            <template v-if="!parsedModel.from">Wähle ein Datum</template>
            <template v-if="parsedModel.from">
                <template v-if="isSingleDate()">
                    <div class="selected-date" v-bind:class="{ collision: hasVacationCollision }">
                        {{ parsedModel.from.format('dd DD MMM') }}
                    </div>
                    <template v-if="hasVacationCollision">
                        An dem Tag ist geschlossen<br/>
                        Wähle ein anderes Datum
                    </template>
                    <template v-if="!hasVacationCollision">
                        Und bis wann suchst du?
                    </template>
                </template>
                <template v-if="!isSingleDate()">
                    <div class="selected-date">{{ parsedModel.from.format('dd DD MMM') }} –
                        {{ parsedModel.to.format('dd DD MMM') }}
                    </div>
                    <template v-if="hasVacationCollision">
                        Am {{ collisionDates[0].format('dd DD MMM') }} ist geschlossen
                    </template>
                </template>
            </template>
        </div>
        <button v-on:click="selectDates()" v-if="parsedModel && !(hasVacationCollision && isSingleDate())" type="button" class="submit-button">
            <template v-if="isSingleDate()">Nur Einzeltermin</template>
            <template v-if="!isSingleDate()">Daten auswählen</template>
        </button>
    </div>
</template>
