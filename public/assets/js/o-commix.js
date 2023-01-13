console.log('o-commix.js loaded');

import * as Vue from '/assets/js/vue.esm-browser.prod.min.js';

// https://vuejs.org/guide/scaling-up/state-management.html
let common = Vue.reactive({
    count: 0,
});

let mixin = {
    created() {
        console.log('mixin created');
    },
    mounted() {
        console.log('mixin mounted');
    },
    computed: {
        center: {
            get() {
                return common;
            },
            set(value) {
                common = value;
            }
        } 
    },
    methods: {
        test2 (msg='') {
            console.log('o-commix test2: ' + msg);
        },
    },
    common, // hack: to make common available in setup() but not in data()
    data() {
        // add data to mixin
        return {
            hello: 'bonjour',
        }
    }
}

export default {
    mixin,
    common, // hack: another hack to make possible to make common available in setup()
}