<style lang="scss" scoped src="./SimpleToggle.scss"></style>
<script lang="ts" src="./SimpleToggle.ts"></script>

<template>
    <div class="simple-toggle">
        <input ref='input' type="hidden" v-bind:name="name">
        <div v-for="option of options"
             v-on:click="onOptionSelected(option)"
             v-bind:class="{ active: value === option.value }"
             class="option">
            {{ option.label }}
        </div>
    </div>
</template>
