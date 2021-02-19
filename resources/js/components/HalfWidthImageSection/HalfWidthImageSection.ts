import Component from 'vue-class-component';
import Vue from 'vue';

const HalfWidthImageSectionProps = Vue.extend({
    props: {
        image: String,
        imagePosition: String,
        invertHeadlines: Boolean
    }
});

@Component
export default class HalfWidthImageSection extends HalfWidthImageSectionProps {

    mounted() {
        const headlines = this.$el.querySelectorAll(`h1, h2, h3, h4, h5, h6`);
        headlines.forEach(headline => {
            this.$el.querySelector('.mobile-image .headlines').appendChild(headline.cloneNode(true));
            headline.classList.add('desktop');
        });
    }

}
