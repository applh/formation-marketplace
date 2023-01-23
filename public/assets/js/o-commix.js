console.log('o-commix.js loaded');

import * as Vue from '/assets/js/vue.esm-browser.prod.min.js';

// https://vuejs.org/guide/scaling-up/state-management.html
let common = Vue.reactive({
    count: 0,
    window_w: window.innerWidth,
    window_h: window.innerHeight,
    api_feedback: '...',
    api_admin_key: '...',
    // crud components
    items: {},
    update_forms: {},
    create_forms: {},
    options: {},
    forms: {},
    api_url: '/api',
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
        load_components (app) {
            // WARNING: REGISTER ASYNC COMPONENTS FIRST
            // <template id="appTemplate" data-compos="test">
            let appTemplate = document.querySelector('#appTemplate');
            let compos = appTemplate?.getAttribute("data-compos");
            if (compos) {
                console.log('compos: ' + compos);
                compos = compos.split(' ');
                compos.forEach(function(name) {
                    console.log('register async component: ' + name);
                    app.component(
                        'o-' + name,
                        Vue.defineAsyncComponent(() => import(`/assets/js/o-${name}.js`))
                    );
                });
            }

        },
        async load_js_order(urls=[], index = 0) {
            if (index >= urls.length) {
                return;
            }

            let url = urls[index] ?? '';
            if (url) {
                let el = document.createElement('script');

                el.setAttribute('src', url);
                el.setAttribute('type', 'text/javascript');
                // el.setAttribute('async', async);
                // defer
                el.setAttribute('defer', true);

                document.body.appendChild(el);

                // success event
                el.addEventListener('load', () => {
                    console.log('File loaded: ' + url)
                    this.load_js_order(urls, index + 1);
                });
                // error event
                el.addEventListener('error', (e) => {
                    console.log('Error on loading file: ' + url, e);
                    this.load_js_order(urls, index + 1);
                });

            }
        },
        async load_js(url, async = true) {
            let el = document.createElement('script');

            el.setAttribute('src', url);
            el.setAttribute('type', 'text/javascript');
            // el.setAttribute('async', async);
            // defer
            el.setAttribute('defer', true);

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
        async load_css(url, async = true) {
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
        async load_form(form_name) {
            // check if form is already loaded in common.forms
            if (common.forms[form_name]) {
                console.log('form already loaded: ' + form_name);
                return common.forms[form_name];
            }
            else {
                console.log('load form: ' + form_name);
                let form = await import(`/assets/js/form-${form_name}.js`);
                common.forms[form_name] = form.default;
                return form.default;
            }
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