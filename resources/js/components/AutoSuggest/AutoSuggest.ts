import Component from 'vue-class-component';
import Vue from 'vue';
import { BehaviorSubject, Subject } from 'rxjs';
import { debounceTime } from 'rxjs/operators';

const AutoSuggestProps = Vue.extend({
    props: {
        value: String,
        minInputLength: Number,
        count: Number,
        suggest: Function
    }
})

@Component
export default class AutoSuggest<T> extends AutoSuggestProps {

    suggestions: T[] = [];
    visible: boolean = false;

    private modelChangeSubject = new BehaviorSubject<string>("");
    private unwatch;

    created() {
        this.unwatch = this.$watch('value', (newValue) => {
            this.modelChangeSubject.next(newValue);
        });

        this.modelChangeSubject.pipe(debounceTime(250)).subscribe((value) => {
            this.onModelChange(value);
        });
    }

    destroyed() {
        this.unwatch();
    }

    async onModelChange(value: string) {
        if (value.trim().length < (this.minInputLength ?? 3)) {
            this.suggestions = [];
            return;
        }

        this.suggestions = (await this.suggest(value)).slice(0, this.count ?? 5);
    }

    setVisible(visible: boolean) {
        setTimeout(() => {
            this.visible = visible;
        }, 100);
    }

}
