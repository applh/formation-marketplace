<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- block search engines -->
    <meta name="robots" content="noindex, nofollow">
    <meta name="description" content="PRIVATE: MEMBER DASHBOARD">

    <title>Member Dashboard</title>
    <link rel="stylesheet" href="/assets/css/site.css">
    <style>
    </style>
    <!-- <script src="/assets/js/uikit-icons.min.js"></script> -->
    <!-- <script src="/assets/js/uikit.min.js"></script> -->
</head>

<body>
    <!-- add vuejs 3 app -->
    <div class="box-vue">
        <div id="app"></div>
        <template id="appTemplate" data-compos="member form">
            <o-member></o-member>
        </template>
    </div>
    <script type="module">
        // check if .box-vue is present
        let box_vue = document.querySelector('.box-vue');
        if (box_vue) {
            // import vue js 3
            let Vue = await import('/assets/js/vue.esm-browser.prod.min.js');

            let commix = await import('/mjs?compo=o-commix');
            let mixins = [commix.default.mixin]; // warning: must add .default

            // separate data for better readability
            const appData = {
                extra_js: [
                    '/assets/js/uikit.min.js',
                    '/assets/js/uikit-icons.min.js',
                ],
                extra_css: [
                    '/assets/css/uikit.min.css'
                ],
            };

            let methods = {

            }

            let created = async function() {
                // weird but works: app is available in created() 
                // as created() is called after app.mount()
                this.load_components(app);

                // load extra css files
                this.extra_css.forEach(async (css) => {
                    await this.load_css(css);
                });

                // load extra js files in order
                this.load_js_order(this.extra_js);
            }

            const app = Vue.createApp({
                template: '#appTemplate',
                mixins,
                methods,
                created,
                data: () => appData,
            })
            // mount vue app
            app.mount('#app');

        }
    </script>

</body>

</html>