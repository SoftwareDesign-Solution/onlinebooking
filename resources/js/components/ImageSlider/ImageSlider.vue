<style lang="scss" scoped src="./ImageSlider.scss"></style>
<script lang="ts" src="./ImageSlider.ts"></script>

<template>
    <div class="image-slider">
        <div class="window">
            <div class="tape">
                <slot></slot>
                <div v-for="image of images" class="image" v-bind:style="`background-image: url('${image}')`"></div>
            </div>
        </div>

        <div v-on:click="previous()" class="slider-control prev">
            <svg-vue icon="angle-left"></svg-vue>
        </div>
        <div v-on:click="next()" class="slider-control next">
            <svg-vue icon="angle-right"></svg-vue>
        </div>
        <div class="slide-number">{{ getPosition() + 1 }}/{{ images.length }}</div>
    </div>
</template>
