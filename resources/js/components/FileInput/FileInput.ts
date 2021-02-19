import Component from 'vue-class-component';
import Vue from 'vue';

const FileInputProps = Vue.extend({
    props: {
        name: String
    }
});

@Component
export default class FileInput extends FileInputProps {
    value: File = null;

    $refs!: {
        input: HTMLInputElement;
    }

    mounted() {
        this.$refs.input.onchange = () => {
            this.value = this.$refs.input.files[0];
        };
    }

    selectFile() {
        this.$refs.input.click();
    }
}
