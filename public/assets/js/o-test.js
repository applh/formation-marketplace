console.log('o-test.js loaded');

import * as Vue from '/assets/js/vue.esm-browser.prod.min.js';

// mixins
import { default as commix } from '/assets/js/o-commix.js';
let mixins = [ commix.mixin ];

let inject = [ 'main_app' ];

// 
let data_compo = {
};

let setup = function () {
    console.log('o-test setup');
    const toto = Vue.ref(0);

    return {
        toto
    }
}

let template = `
<div class="uk-section">
    <div class="uk-container">
        <h1>o-test</h1>
        <button class="uk-button" @click.prevent="center.count++">{{ center.count }}</button>
    </div>
</div>
`;

let methods = {

}

let created = function () {
    this.main_app.test('o-test created');
    console.log(this.toto++);
}

let mounted = function () {
    this.main_app.test('o-test mounted');
    console.log(this.toto++);
}


// vue js async component
export default {
    template,
    inject,

    // data will share the same object between all instances
    data: () => data_compo,
    // data will be a new object for each instance
    //     data: () => JSON.parse(JSON.stringify(data_compo)),

    mixins,
    setup,
    methods,
    setup,
    created,
    mounted,
}