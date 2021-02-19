<style lang="scss" scoped src="./Sidebar.scss"></style>
<script lang="ts" src="./Sidebar.ts"></script>

<template>
    <div class="sidebar-container" v-bind:class="{'visible': isVisible}">
        <div class="sidebar-toggle">
            <div class="toggle-button" v-bind:class="{'visible': isVisible}" v-on:click="toggle()">
                <svg-vue icon="sidebar-toggle"></svg-vue>
            </div>
        </div>
        <div class="sidebar-content">
            <slot></slot>
        </div>
    </div>
</template>
