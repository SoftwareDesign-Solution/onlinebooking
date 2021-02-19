import Vue from 'vue';
import Component from 'vue-class-component';
import Hammer from "hammerjs";

@Component
export default class ImageSlider extends Vue {

    images: string[] = [];

    private tape: HTMLDivElement;
    private dragOffset: number = 0;

    mounted() {
        this.initializeSlides();
        this.initializeTouchEvents();
    }

    private initializeSlides() {
        this.images = [];
        this.$el.querySelectorAll('img').forEach(img => {
            this.images.push(img.src);
            img.remove();
        });
    }

    private initializeTouchEvents() {
        this.tape = this.$el.querySelector('.tape');
        const mc = new Hammer.Manager(this.tape);
        const pan = new Hammer.Pan({
            direction: Hammer.DIRECTION_HORIZONTAL
        });
        mc.add(pan);

        mc.on('pan', (e) => {
            this.setDrag(e.deltaX + this.dragOffset);
        });

        mc.on('panstart', (e) => {
            this.tape.classList.add('panning');
        });

        mc.on('panend', (e) => {
            this.tape.classList.remove('panning');
            this.dragOffset = this.getDrag();
            this.dragOffset = Math.round(this.dragOffset / this.$el.clientWidth) * this.$el.clientWidth;
            this.snap();
        });
    }

    next() {
        this.dragOffset -= this.$el.clientWidth;
        this.snap();
    }

    previous() {
        this.dragOffset += this.$el.clientWidth;
        this.snap();
    }

    private snap() {
        if (this.dragOffset > 0) {
            this.dragOffset = 0;
        }
        if (this.dragOffset < -this.$el.clientWidth * (this.images.length - 1)) {
            this.dragOffset = -this.$el.clientWidth * (this.images.length - 1);
        }
        this.setDrag(this.dragOffset);
    }

    getPosition() {
        return this.dragOffset ? -this.dragOffset / this.$el.clientWidth : 0;
    }

    getDrag() {
        return parseInt(this.tape.style.getPropertyValue('--drag'));
    }

    setDrag(value: number) {
        this.tape.style.setProperty('--drag', `${value}`);
    }

}
