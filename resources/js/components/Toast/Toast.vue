<style lang="scss" src="./Toast.scss"></style>
<script lang="ts" src="./Toast.ts"></script>

<template class="toast">
    <div class="toast-content" v-on:click="hide()" v-bind:class="{ 'open' : open, 'notification-toast-content': isNotificationToast }">
        <div class="close-toast-button">
            <svg-vue icon="times"></svg-vue>
        </div>
        <slot></slot>
        <template v-if="isNotificationToast">
            <p class="content">{{ message }}</p>
            <button type="button" v-on:click="hide()">Meldung schließen</button>
        </template>
    </div>
</template>
