<style lang="scss" scoped src="./TimeSelector.scss"></style>
<script lang="ts" src="./TimeSelector.ts"></script>

<template>
    <div class="time-selector">
        <div class="hour">{{ `${value}`.padStart(2, '0') }} : 00</div>
        <div class="buttons">
            <div class="button" v-on:click="increase()" v-bind:class="{ disabled: value === this.max }">
                <svg-vue icon="angle-up"></svg-vue>
            </div>
            <div class="button" v-on:click="decrease()" v-bind:class="{ disabled: value === this.min }">
                <svg-vue icon="angle-down"></svg-vue>
            </div>
        </div>
    </div>
</template>
