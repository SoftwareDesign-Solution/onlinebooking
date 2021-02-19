<style lang="scss" scoped src="./RoomPhotoUpload.scss"></style>
<script lang="ts" src="./RoomPhotoUpload.ts"></script>

<template>
    <div class="photos">
        <div class="photo-upload">
            <file-input class="file-input" ref="input"></file-input>
            <button v-on:click="uploadPhoto()" type="button">Foto hochladen</button>
        </div>

        <div class="photo-list" v-if="photos">
            <div  v-for="photo of photos" class="photo">
                <div class="delete-button" v-on:click="deletePhoto(photo)">
                    <svg-vue icon="times"></svg-vue>
                </div>

                <div class="image-container">
                    <img v-bind:src="`/api/rooms/${roomId}/photos/${photo.filename}`">
                </div>
            </div>
        </div>
    </div>
</template>
