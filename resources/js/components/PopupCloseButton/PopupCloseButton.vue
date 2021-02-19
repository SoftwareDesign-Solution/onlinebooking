<style lang="scss" scoped src="./PopupCloseButton.scss"></style>
<script lang="ts" src="./PopupCloseButton.ts"></script>

<template>
    <div class="popup-close-button" v-on:click="closePopup()">
        <svg-vue icon="times"></svg-vue>
    </div>
</template>
