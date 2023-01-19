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
</head>
<body>
    <!-- add vuejs 3 app -->
    <div class="box-vue">
        <div id="app"></div>
        <template id="appTemplate" data-compos="member">
            <o-member></o-member>
        </template>
    </div>
<script type="module">
// check if .box-vue is present
let box_vue = document.querySelector('.box-vue');
if (box_vue) {
    // import vue js 3
    let Vue = await import('/assets/js/vue.esm-browser.prod.min.js');

    let commix = await import('/assets/js/o-commix.js');
    let mixins = [commix.default.mixin]; // warning: must add .default

    let created = async function() {
        // weird but works: app is available in created() 
        // as created() is called after app.mount()
        this.load_components(app);
    }

    const app = Vue.createApp({
        template: '#appTemplate',
        mixins,
        created,
    })
    // mount vue app
    app.mount('#app');

}
</script>

</body>
</html>