# formation-marketplace

Build your own marketplace with PHP+SQL

## PHP as local web server

* https://www.php.net/manual/en/features.commandline.webserver.php
* To start coding with PHP, you can use the built-in web server. This is a simple web server that is bundled with PHP. It is designed to be used for development only. It is not recommended to use it in a production environment.

```
.
└── marketplace
    ├── LICENSE
    ├── README.md
    └── public
        └── index.php
    
# go to the public/ folder
# and start the web server with this command
php -S localhost:9876

```

* Inside VSCode, you can develop by SSH and use port forwarding to view the web page in your local browser

* Inside VSCode, you can also use the "PHP Server" extension to start the web server

## DEV SETPS

### V0.0.1 INIT

```
.
└── marketplace
    ├── LICENSE
    ├── README.md
    └── public
        └── index.php

```

### V0.0.2 BASIC HTML, CSS, JS

* add css and js files
* add image

```
.
└── marketplace
    ├── LICENSE
    ├── README.md
    └── public
        ├── assets
        │   ├── photo-1.jpg
        │   ├── site.css
        │   └── site.js
        └── index.php

3 directories, 6 files
```

# V0.0.3 UIKIT

* add UIkit
* https://getuikit.com/docs/introduction
* UIkit is a lightweight and modular front-end framework for developing fast and powerful web interfaces.
* UIkit is very easy to use and customize. It is based on a flexible grid system, various components, useful JavaScript extensions and works seamlessly on all major browsers, tablets and phones.


* https://getuikit.com/
* as we now have lot of files, add subfolder for css, js and media
    * unzip uikit.zip files in folders assets/css and assets/js
    * move site.css in assets/css
    * move site.js in assets/js
    * move photo-1.jpg in assets/media
* edit index.php to use UIkit
* to check UIkit os working, add a sortable list in index.php
    * https://getuikit.com/docs/sortable

```
.
└── marketplace
    ├── LICENSE
    ├── README.md
    └── public
        ├── assets
        │   ├── css
        │   │   ├── site.css
        │   │   ├── uikit-rtl.css
        │   │   ├── uikit-rtl.min.css
        │   │   ├── uikit.css
        │   │   └── uikit.min.css
        │   ├── js
        │   │   ├── site.js
        │   │   ├── uikit-icons.js
        │   │   ├── uikit-icons.min.js
        │   │   ├── uikit.js
        │   │   └── uikit.min.js
        │   └── media
        │       └── photo-1.jpg
        └── index.php

6 directories, 14 files
```

# V0.0.4 VUEJS

* add VueJS by CDN
* https://cdnjs.com/libraries/vue
* take the latest esm-browser version
    * in 2023/01, the current version is 3.2.45
* https://cdnjs.cloudflare.com/ajax/libs/vue/3.2.45/vue.esm-browser.prod.min.js
* add Vue3 basic code in index.php

```html
    <!-- add vuejs 3 app -->
    <div id="app"></div>
    <template id="appTemplate">
        <p>{{ message }}</p>
    </template>
    <script type="module">
        // import vue js 3
        import * as Vue from 'https://cdnjs.cloudflare.com/ajax/libs/vue/3.2.45/vue.esm-browser.prod.min.js';
        // create vue app
        const app = Vue.createApp({
            template: '#appTemplate',
            data() {
                return {
                    message: 'Hello Vue 3!'
                }
            }
        });
        // mount vue app
        app.mount('#app');
    </script>
```

* then, we can use a local version of VueJS
* and check UIkit and VueJS are working together

```html
    <!-- add vuejs 3 app -->
    <div id="app"></div>
    <template id="appTemplate">
        <p>{{ message }}</p>
        <div uk-sortable>
            <div><p>ITEM 1 {{ message }}</p></div>
            <div><p>ITEM 2 {{ message }}</p></div>
            <div><p>ITEM 3 {{ message }}</p></div>
        </div>
    </template>
    <script type="module">
        // import vue js 3
        import * as Vue from '/assets/js/vue.esm-browser.prod.min.js';
        // create vue app
        const app = Vue.createApp({
            template: '#appTemplate',
            data() {
                return {
                    message: 'Hello Vue 3!'
                }
            }
        });
        // mount vue app
        app.mount('#app');
    </script>
```

```
.
└── marketplace
    ├── LICENSE
    ├── README.md
    └── public
        ├── assets
        │   ├── css
        │   │   ├── site.css
        │   │   ├── uikit-rtl.css
        │   │   ├── uikit-rtl.min.css
        │   │   ├── uikit.css
        │   │   └── uikit.min.css
        │   ├── js
        │   │   ├── site.js
        │   │   ├── uikit-icons.js
        │   │   ├── uikit-icons.min.js
        │   │   ├── uikit.js
        │   │   ├── uikit.min.js
        │   │   └── vue.esm-browser.prod.min.js
        │   └── media
        │       └── photo-1.jpg
        └── index.php

6 directories, 15 files

uikit.min.js is about 132 KB
vue.esm-browser.prod.min.js is about 126 KB

uikit.min.css is about 256 KB

```

# V0.0.5 PHP API + JS FETCH (AJAX)

* add api.php

```php
<?php

$now = date("Y-m-d H:i:s");

// PHP associative array
$data = [
    "now" => $now,
    "feedback" => "api is ready ($now)",
    "request" => $_REQUEST,
];

// important to set the content type to JSON
header("Content-Type: application/json");
// convert PHP array to JSON
echo json_encode($data);

```
* add ajax fetch call in Vue `created` callback

```html
    <!-- add vuejs 3 app -->
    <div id="app"></div>
    <template id="appTemplate">
        <p>{{ api_feedback }}</p>
        <div uk-sortable>
            <div><p>ITEM 1 {{ message }}</p></div>
            <div><p>ITEM 2 {{ message }}</p></div>
            <div><p>ITEM 3 {{ message }}</p></div>
        </div>
    </template>
    <script type="module">
        // import vue js 3
        import * as Vue from '/assets/js/vue.esm-browser.prod.min.js';
        // create vue app

        // separate data for better readability
        const appData = {
            api_feedback: '...',
            message: 'Hello Vue 3!'
        };

        const app = Vue.createApp({
            template: '#appTemplate',
            data: () => appData,
            async created() {
                // fetch data from api
                let response = await fetch('/api.php');
                let json = await response.json();
                this.api_feedback = json.feedback ?? 'xxx';
            }
        });
        
        // mount vue app
        app.mount('#app');
    </script>

```

* check the page index.php is working ok

```
.
└── marketplace
    ├── LICENSE
    ├── README.md
    └── public
        ├── assets
        │   ├── css
        │   │   ├── site.css
        │   │   ├── uikit-rtl.css
        │   │   ├── uikit-rtl.min.css
        │   │   ├── uikit.css
        │   │   └── uikit.min.css
        │   ├── js
        │   │   ├── site.js
        │   │   ├── uikit-icons.js
        │   │   ├── uikit-icons.min.js
        │   │   ├── uikit.js
        │   │   ├── uikit.min.js
        │   │   └── vue.esm-browser.prod.min.js
        │   └── media
        │       └── photo-1.jpg
        ├── api.php
        └── index.php
```

## CREDITS

* Thanks to Pexels for the free images

