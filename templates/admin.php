<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- block search engines -->
    <meta name="robots" content="noindex, nofollow">
    <meta name="description" content="PRIVATE: ADMIN">

    <title>ADMIN</title>

    <!-- <link rel="stylesheet" href="/assets/css/uikit.min.css"> -->
    <link rel="stylesheet" href="/assets/css/site.css">
    <style>
        /* admin only css */
        /* limit height to 5 rem */
        td>div {
            max-height: 5rem;
            overflow-y: auto;
        }

        td>div:hover {
            max-height: 10rem;
            overflow-y: auto;
        }
        .o-crud {
            border: 1px solid #ccc;
        }
        .o-crud > h3 {
            padding: 1rem;
            border-bottom: 1px solid #ccc;
        }
    </style>
</head>

<body>
    <!-- add vuejs 3 app -->
    <div class="box-vue">
        <div id="app"></div>
        <template id="appTemplate" data-compos="panel sidebar crud geocms post post-crud test">
            <o-panel></o-panel>
        </template>
    </div>
    <script type="module">
        // check if .box-vue is present
        let box_vue = document.querySelector('.box-vue');
        if (box_vue) {
            // import vue js 3
            // better way to load Vue ?
            let Vue = await import('/assets/js/vue.esm-browser.prod.min.js');

            let commix = await import('/assets/js/o-commix.js');
            let mixins = [commix.default.mixin]; // warning: must add .default

            // create vue app
            // separate data for better readability
            const appData = {
                cud_action_post: 'create',
                admin_api_key: '',
                extra_js: [
                    '/assets/js/uikit.min.js',
                    '/assets/js/uikit-icons.min.js',
                ],
                extra_css: [
                    '/assets/css/uikit.min.css'
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
                    // weird but works: app is available in created() 
                    // as created() is called after app.mount()
                    this.load_components(app);

                    // load extra css files
                    this.extra_css.forEach(async (css) => {
                        await this.load_css(css);
                    });

                    // load extra js files in order
                    this.load_js_order(this.extra_js);

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
                async mounted() {
                    // load admin_api_key from local storage
                    this.center.api_admin_key = localStorage.getItem('api_admin_key');
                },
                provide() {
                    return {
                        // tricky way to pass 'this' to child components
                        main_app: this,
                    }
                },
                methods: {
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
                    async test(p = '') {
                        console.log('test: ' + p);
                        this.test2(p);
                    },
                }
            });

            // mount vue app
            app.mount('#app');
        }
    </script>

</body>

</html>