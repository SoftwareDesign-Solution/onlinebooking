<style lang="scss" scoped src="./RoomsPopup.scss"></style>
<script lang="ts" src="./RoomsPopup.ts"></script>

<template>
    <div class="rooms-popup-content container">
        <popup-close-button></popup-close-button>
        <div class="rooms row">
            <div v-for="room of rooms" class="col-12">
                <div class="room" v-bind:class="{selected: isSelected(room)}" v-on:click="toggleSelection(room)">
                    <div class="header">
                        <div class="name">{{ room.name }}</div>
                        <div class="rate">{{ room.rate }}€/h</div>
                        <div class="icons">
                            <template v-if="room.smoking">
                                <svg-vue icon="smoking"></svg-vue>
                            </template>
                            <template v-if="!room.smoking">
                                <svg-vue icon="smoking-ban" class="warning"></svg-vue>
                            </template>

                            <template v-if="room.air_conditioned">
                                <svg-vue icon="snowflake"></svg-vue>
                            </template>
                        </div>
                    </div>
                    <div class="genre">{{ room.genre }}</div>
                    <div class="bottom">
                        <div class="description">
                            {{ room.smoking ? 'Raucherraum' : 'Nichtraucherraum' }}
                            <template v-if="room.air_conditioned">, klimatisiert</template>
                        </div>
                        <div class="checkbox">
                            <input type="checkbox" v-bind:checked="isSelected(room)">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="actions row">
            <div class="col-12">
                <div class="mark-all" v-on:click="selectAll()">
                    <label>Alle Proberäume markieren</label> <input type="checkbox" v-bind:checked="allSelected()">
                </div>
            </div>
            <hr>
            <div class="selection-label col-12">
                <template v-if="selectedRooms.length === 0">
                    Keine Proberäume markiert
                </template>
                <template v-if="selectedRooms.length === 1">
                    {{ selectedRooms[0].name }} markiert
                </template>
                <template v-if="selectedRooms.length > 1">
                    {{ selectedRooms.slice(0).reverse().slice(1).reverse().map(room => room.name).join(", ") }} und {{ selectedRooms.slice(0).reverse()[0].name }} markiert.
                </template>
            </div>
            <div class="col-12">
                <button v-bind:disabled="selectedRooms.length === 0" v-on:click="finishRoomSelection()" type="button">Proberäume auswählen</button>
            </div>
        </div>
    </div>
</template>
