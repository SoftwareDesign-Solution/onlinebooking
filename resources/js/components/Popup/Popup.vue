<style lang="scss" src="./Popup.scss"></style>
<script lang="ts" src="./Popup.ts"></script>

<template class="popup">
    <div class="popup-content" v-bind:class="{ 'open' : open }">
        <slot></slot>
    </div>
</template>
