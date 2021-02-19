<style lang="scss" scoped src="./StyledSelect.scss"></style>
<script lang="ts" src="./StyledSelect.ts"></script>

<template>
    <div class="styled-select">
        <select ref="select" v-bind:name="name" v-model="value">
            <slot></slot>
        </select>
        <div class="caret">
            <svg-vue icon="angle-down"></svg-vue>
        </div>
    </div>
</template>
