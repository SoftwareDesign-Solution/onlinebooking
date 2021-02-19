<style lang="scss" scoped src="./NavPopupCloseButton.scss"></style>
<script lang="ts" src="./NavPopupCloseButton.ts"></script>

<template>
    <div class="popup-close-button" v-bind:class="{ 'popup-open': isPopupOpen }">
        <div class="button" v-on:click="closeCurrentPopup()">
            <svg-vue icon="times" class="user-icon"></svg-vue>
        </div>
        <div class="fallback">
            <slot></slot>
        </div>
    </div>
</template>
