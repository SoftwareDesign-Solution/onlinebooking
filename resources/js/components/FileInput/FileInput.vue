<style lang="scss" scoped src="./FileInput.scss"></style>
<script lang="ts" src="./FileInput.ts"></script>

<template>
    <div class="file-input">
        <input ref="input" v-bind:name="name" type="file">
        <button type="button" v-on:click="selectFile()">Datei auswählen</button>
        <div class="value">
            <template v-if="!value">
                Keine ausgewählt
            </template>
            <template v-if="value">
                {{ value.name }}
            </template>
        </div>
    </div>
</template>
