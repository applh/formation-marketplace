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

### ARCHIVES

* V0.0.x read the [V0.0.x Coding-recipes](Coding-recipes-v0.md)
* V0.1.x read the [V0.1.x Coding-recipes](Coding-recipes-v1.md)

### V0.2.0 ADMIN PAGE / CRUD + ASYNC VUE COMPONENT

* add vue async component o-crud
    * prop `table` to select the table to CRUD
    * read display in a table
    * delete button and api item delete

* debug and improvements
    * add login form to store admin_api_key in browser local storage
        * easier to test api_admin...
    * better UIkit grid layout and UX

### V0.2.1 ADMIN PAGE / CRUD + ASYNC VUE COMPONENT

* add class cms to define models (post, user, ...)
* add general CRUD forms in async component o-crud

* debug and improvements
    * need to deep copy object to have separate instances of vue components
    * https://code.tutsplus.com/articles/the-best-way-to-deep-copy-an-object-in-javascript--cms-39655
    * add checkbox to hide/show CRU panels in admin page

### V0.2.2 VUE ADD MIXIN AND CENTER STATE MANAGEMENT

* https://vuejs.org/api/options-composition.html#mixins
* https://vuejs.org/guide/scaling-up/state-management.html

* debug and improvements
    * code refactoring
    * various tests on Vue mixins and setup() reactivity
    * JS dynamic module import

#### CODE STRUCTURE

```
.
├── media
├── my-data
├── public
│   ├── assets
│   │   ├── css
│   │   │   ├── site.css
│   │   │   ├── uikit-rtl.css
│   │   │   ├── uikit-rtl.min.css
│   │   │   ├── uikit.css
│   │   │   └── uikit.min.css
│   │   ├── js
│   │   │   ├── admin.js
│   │   │   ├── o-crud.js
│   │   │   ├── o-test.js
│   │   │   ├── site.js
│   │   │   ├── uikit-icons.js
│   │   │   ├── uikit-icons.min.js
│   │   │   ├── uikit.js
│   │   │   ├── uikit.min.js
│   │   │   └── vue.esm-browser.prod.min.js
│   │   └── media
│   │       └── photo-1.jpg
│   └── index.php
├── framework.php
├── class
│   ├── api_admin.php
│   ├── api_public.php
│   ├── cli.php
│   ├── cms.php
│   ├── control.php
│   ├── model.php
│   ├── os.php
│   ├── sample.php
│   ├── sqlite.php
│   └── web.php
└── templates
    ├── 404.php
    ├── admin.php
    ├── adminer
    │   └── index.php
    ├── adminer.php
    ├── api.php
    ├── home.php
    ├── post.php
    └── robots.php

```

## CREDITS

* Thanks to Pexels for the free images
* Thanks to Lorem Picsum for the free images


