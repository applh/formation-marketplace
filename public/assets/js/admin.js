console.log('Your marketplace is ready to go!');

// check if .box-vue is present
let box_vue = document.querySelector('.box-vue');

// import vue js 3
import * as Vue from '/assets/js/vue.esm-browser.prod.min.js';

if (box_vue) {
    console.log('setup vue app...');

    // create vue app

    // separate data for better readability
    const appData = {
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
        data: () => appData,
        async created() {
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
            }
        }
    });

    // mount vue app
    app.mount('#app');
}
