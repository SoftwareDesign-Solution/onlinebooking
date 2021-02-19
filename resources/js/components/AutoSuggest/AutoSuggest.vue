<style lang="scss" src="./AutoSuggest.scss" scoped></style>
<script lang="ts" src="./AutoSuggest.ts"></script>

<template>
    <div class="suggestions" v-bind:class="{ 'hidden': !visible }">
        <div v-for="suggestion of suggestions" class="suggestion" v-on:click="$emit('change', suggestion)">
            <slot v-bind:suggestion="suggestion"></slot>
        </div>
    </div>
</template>
