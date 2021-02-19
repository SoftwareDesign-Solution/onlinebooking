<style lang="scss" scoped src="./HalfWidthImageSection.scss"></style>
<script lang="ts" src="./HalfWidthImageSection.ts"></script>

<template>
    <div class="half-width-image-section">
        <div class="container">
            <div class="row">
                <template v-if="imagePosition === 'right'">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-5 section-content">
                        <div class="mobile-image row" v-bind:style="`background-image: url('${ image }')`">
                            <div class="col-12 headlines"></div>
                        </div>
                        <div class="content">
                            <slot></slot>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="half-width-image right" v-bind:style="`background-image: url('${ image }')`"></div>
                    </div>
                </template>
                <template v-if="imagePosition === 'left'">
                    <div class="col-lg-6">
                        <div class="half-width-image left" v-bind:style="`background-image: url('${ image }')`"></div>
                    </div>
                    <div class="col-lg-5 section-content">
                        <div class="mobile-image row" v-bind:style="`background-image: url('${ image }')`">
                            <div class="col-12 headlines"></div>
                        </div>
                        <div class="content">
                            <slot></slot>
                        </div>
                    </div>
                    <div class="col-lg-1"></div>
                </template>
            </div>
        </div>
    </div>
</template>
