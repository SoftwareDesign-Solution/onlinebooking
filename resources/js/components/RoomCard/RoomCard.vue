<style lang="scss" scoped src="./RoomCard.scss"></style>
<script lang="ts" src="./RoomCard.ts"></script>

<template>
    <div class="room-card" v-bind:style="roomPhotos && roomPhotos[0] ? `background-image: url('/api/rooms/${room.id}/photos/${roomPhotos[0].filename}')` : ''">
        <template v-if="room">
            <div class="content">
                <div class="genre">{{ room.genre }}</div>
                <div class="name">{{ room.name }}</div>
            </div>
            <div class="buttons">
                <a v-bind:href="`/rooms/${ room.id }`" class="button small secondary">Mehr erfahren</a>
                <a v-bind:href="`/rooms/${ room.id }/book`" class="button small">Termin suchen</a>
            </div>
        </template>
    </div>
</template>
