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

## CODING RECIPES

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

### V0.0.3 UIKIT

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

### V0.0.4 VUEJS

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

### V0.0.5 PHP API + JS FETCH (AJAX)

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

6 directories, 16 files
```

### V0.0.6 UIKIT + CARDS + SORTABLE + VUE LOOP

* add UIkit cards + sortable in index.php
    * https://getuikit.com/docs/card
    * https://getuikit.com/docs/sortable

* Vue list rendering (loop)
    * https://vuejs.org/guide/essentials/list.html

* UIkit and Vue are working together so easily 😍

```html
    <!-- add vuejs 3 app -->
    <div id="app"></div>
    <template id="appTemplate">
        <section>
            <p>{{ api_feedback }}</p>
        </section>
        <section>
            <h2>UIkit: card</h2>
            <div class="uk-child-width-1-4@m" uk-grid uk-sortable>
                <div v-for="post in posts">
                    <div class="uk-card uk-card-default">
                        <div class="uk-card-media-top">
                            <img src="/assets/media/photo-1.jpg" width="1800" height="1200" alt="">
                        </div>
                        <div class="uk-card-body">
                            <h3 class="uk-card-title">{{ post.title }}</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </template>
    <script type="module">
        // import vue js 3
        import * as Vue from '/assets/js/vue.esm-browser.prod.min.js';
        // create vue app

        // separate data for better readability
        const appData = {
            posts: [
                {
                    title: 'Post 1'
                },
                {
                    title: 'Post 2'
                },
                {
                    title: 'Post 3'
                },
                {
                    title: 'Post 4'
                }
            ],
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

### V0.0.7 PHP LOOP OR VUE LOOP + TELEPORT

* Objectives
    * create a PHP loop (better SEO)
    * create a Vue loop (better UX)

* add file framework.php
    * centralize the array of posts  
    * add require in files index.php and api.php
  
* add code in file index.php
    * loop in PHP
    * loop in Vue + teleport
    * https://vuejs.org/guide/built-ins/teleport.html
    * https://vuejs.org/guide/essentials/list.html

```html
    <main>
        <h1>Your MarketPlace</h1>
        <p>Current time: <?php echo $now; ?></p>
        <img src="/assets/media/photo-1.jpg" alt="">

        <section>
            <h2>RECENT POSTS (PHP loop) 🔥</h2>
            <div class="uk-child-width-1-2@m uk-child-width-1-4@l" uk-grid uk-sortable>
                <?php foreach ($posts as $post) : ?>
                    <?php extract($post) ?>
                    <div>
                        <div class="uk-card uk-card-default">
                            <div class="uk-card-media-top">
                                <img src="<?php echo $image ?>" width="1800" height="1200" alt="">
                            </div>
                            <div class="uk-card-body">
                                <h3 class="uk-card-title"><?php echo $title ?></h3>
                                <p><?php echo $description ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <div class="box-posts">
            <!-- Vue will teleport posts here -->
        </div>
    </main>
    <footer>
        <p>Your MarketPlace &copy; 2023</p>
    </footer>

    <!-- add vuejs 3 app -->
    <div id="app"></div>
    <template id="appTemplate">
        <section>
            <p>{{ api_feedback }}</p>
        </section>

        <Teleport to=".box-posts">
            <section>
                <h2>RECENT POSTS (list by Vue / loop + teleport) 🔥</h2>
                <div class="uk-child-width-1-2@m uk-child-width-1-4@l" uk-grid uk-sortable>
                    <div v-for="post in posts">
                        <div class="uk-card uk-card-default">
                            <div class="uk-card-media-top">
                                <img :src="post.image" width="1800" height="1200" alt="">
                            </div>
                            <div class="uk-card-body">
                                <h3 class="uk-card-title">{{ post.title }}</h3>
                                <p>{{ post.description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </Teleport>

    </template>
    <script type="module">
        // import vue js 3
        import * as Vue from '/assets/js/vue.esm-browser.prod.min.js';
        // create vue app

        // separate data for better readability
        const appData = {
            posts: [],
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
                this.posts = json.posts ?? [];
            }
        });

        // mount vue app
        app.mount('#app');
    </script>

```

#### CODE ORGANISATION

```
.
└── marketplace
    ├── LICENSE
    ├── README.md
    ├── framework.php
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

6 directories, 17 files
```

* framework.php

```php
<?php

$posts = [
    [
        'title' => 'Post 1',
        'image' => 'https://picsum.photos/id/1/640/640',
        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
    ],
    [
        'title' => 'Post 2',
        'image' => 'https://picsum.photos/id/2/640/640',
        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
    ],
    [
        'title' => 'Post 3',
        'image' => 'https://picsum.photos/id/3/640/640',
        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
    ],
    [
        'title' => 'Post 4',
        'image' => 'https://picsum.photos/id/4/640/640',
        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
    ],
];

```

### V0.0.8 UIKIT / LIGHTBOX + SCROLLSPY

Effects and animation are UX features that can make your website more attractive and engaging. UIkit provides a set of effects and animations that you can use to make your website more interactive.

Human beings are visual creatures. We are attracted to images and videos. We are also attracted to movement. UIkit provides a set of effects and animations that you can use to make your website more interactive.

* https://getuikit.com/docs/lightbox
* https://getuikit.com/docs/scrollspy

## CREDITS

* Thanks to Pexels for the free images
* Thanks to Lorem Picsum for the free images


