console.log('Your marketplace is ready to go!');

// check if .box-vue is present
let box_vue = document.querySelector('.box-vue');

// import vue js 3
// import * as Vue from '/assets/js/vue.esm-browser.prod.min.js';

if (box_vue) {
    // better way to load Vue ?
    let Vue = await import('/assets/js/vue.esm-browser.prod.min.js');
    console.log(Vue);

    // import { default as commix } from '/assets/js/o-commix.js';
    let commix = await import('/assets/js/o-commix.js');
    let mixins = [ commix.default.mixin ]; // warning: must add .default

    console.log('setup vue app...');

    // create vue app

    // separate data for better readability
    const appData = {
        cud_action_post: 'create',
        admin_api_key: '',
        extra_js: [
            '/assets/js/uikit.min.js',
            // '/assets/js/uikit-icons.min.js',
        ],
        api_uri: '/api', // using PHP framework router
        posts: [],
        api_feedback: '...',
        message: 'Hello Vue 3!'
    };

    const app = Vue.createApp({
        template: '#appTemplate',
        mixins,
        data: () => appData,
        async created() {
            // WARNING: REGISTER ASYNC COMPONENTS FIRST
            // <template id="appTemplate" data-compos="test">
            let appTemplate = document.querySelector('#appTemplate');
            let compos = appTemplate?.getAttribute("data-compos");
            if (compos) {
                compos = compos.split(' ');
                compos.forEach(function (name) {
                    console.log('register component: o-' + name);
                    app.component(
                        'o-' + name,
                        Vue.defineAsyncComponent(() => import(`/assets/js/o-${name}.js`))
                    );
                });
            }

            // load extra js files
            this.extra_js.forEach((js) => {
                this.load_js(js);
            });

            // load posts from api
            let data = new FormData();
            data.append('m', 'posts');
            // fetch data from api
            let response = await fetch(this.api_uri, {
                method: 'POST',
                body: data
            });
            let json = await response.json();
            this.api_feedback = json.feedback ?? 'xxx';
            this.posts = json.posts ?? [];

            this.center.title = 'MY TITLE';
            this.center.count = 123;
        },
        async mounted () {
            // load admin_api_key from local storage
            this.admin_api_key = localStorage.getItem('admin_api_key');
        },
        provide() {
            return {
                // tricky way to pass 'this' to child components
                main_app: this,
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
            async send_form(event) {
                event.preventDefault();
                let form = event.target;
                // console.log(form);
                let data = new FormData(form);
                let response = await fetch(this.api_uri, {
                    method: 'POST',
                    body: data
                });
                let json = await response.json();
                console.log(json);
                this.api_feedback = json.feedback ?? 'xxx';

                if (json.posts) {
                    // refresh posts
                    this.posts = json.posts;
                }

            },
            async test (p='') {
                console.log('test: ' + p);
                this.test2(p);
            },
            async login () {
                // save admin_api_key to local storage
                localStorage.setItem('admin_api_key', this.admin_api_key);
            }
        }
    });

    // mount vue app
    app.mount('#app');
}
