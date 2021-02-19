<style scoped lang="scss" src="./PopupButtonInput.scss"></style>
<script type="ts" src="./PopupButtonInput.ts"></script>

<template>
    <div class="popup-button" v-on:click="$emit('click')">
        <div class="label">{{ label }}</div>
        <div class="value">
            <slot></slot>
        </div>
    </div>
</template>
