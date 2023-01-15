console.log('o-commix.js loaded');

import * as Vue from '/assets/js/vue.esm-browser.prod.min.js';

// https://vuejs.org/guide/scaling-up/state-management.html
let common = Vue.reactive({
    count: 0,
    window_w: window.innerWidth,
    window_h: window.innerHeight,
    api_feedback: '...',
});

// add event listener on window resize
window.addEventListener('resize', () => {
    common.window_w = window.innerWidth;
    common.window_h = window.innerHeight;
    console.log('window resize: ' + common.window_w + 'x' + common.window_h);
});

let mixin = {
    created() {
        // console.log('mixin created');
    },
    mounted() {
        // console.log('mixin mounted');
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
        load_js(url, async = true) {
            let el = document.createElement('script');

            el.setAttribute('src', url);
            el.setAttribute('type', 'text/javascript');
            el.setAttribute('async', async);

            document.body.appendChild(el);

            // success event
            el.addEventListener('load', () => {
                console.log('File loaded: ' + url)
            });
            // error event
            el.addEventListener('error', (e) => {
                console.log('Error on loading file: ' + url, e);
            });
        },
        load_css(url, async = true) {
            let el = document.createElement('link');

            el.setAttribute('href', url);
            el.setAttribute('type', 'text/css');
            el.setAttribute('rel', 'stylesheet');
            document.head.appendChild(el);

            // success event
            el.addEventListener('load', () => {
                console.log('File loaded: ' + url)
            });
            // error event
            el.addEventListener('error', (e) => {
                console.log('Error on loading file: ' + url, e);
            });
        },
        test2 (msg='') {
            // console.log('o-commix test2: ' + msg);
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