# CODING RECIPES

## V0.2.x

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


### V0.2.3 VARIOUS HACKS ON VUEJS

* combining JS import with Vue composition setup() can open new possibilities
* https://vuejs.org/api/composition-api-setup.html#dynamic-module-imports

#### CODE STRUCTURE

```
.
├── Coding-recipes-v0.md
├── Coding-recipes-v1.md
├── LICENSE
├── README.md
├── media
├── my-data
├── public
│   ├── assets
│   │   ├── css
│   │   ├── js
│   │   │   ├── o-commix.js
│   │   │   ├── o-crud.js
│   │   │   ├── o-test.js
│   │   │   ├── site.js
│   │   │   ├── uikit-icons.js
│   │   │   ├── uikit-icons.min.js
│   │   │   ├── uikit.js
│   │   │   ├── uikit.min.js
│   │   │   └── vue.esm-browser.prod.min.js
│   │   └── media
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
    ├── robots.php
    └── vue
        ├── admin-app.php
        └── admin.js
```

### V0.2.4 ADD SQL TABLE GEOCMS AND VIEW POST

* add SQL table geocms
* add SQL view post built from geocms
* update CRUD forms Vue and api_admin::crud() to use geocms

* TODO: load tests...
* expected sqlite file size depending on SQL data volume ?
    * around 3K per SQL row ?
    * around 3M per 1.000 SQL rows ?
    * around 30M per 10.000 SQL rows ?
    * around 300M per 100.000 SQL rows ?

* typical blog website
    * around 100 pages+posts
        * = 100 pages/posts * 100 blocks per page
        * around 10.000 SQL rows
        * around 30M sqlite file size
    * around 1.000 images
* debug and improvements
    * template can be PHP callable

### V0.2.5 DEBUG

* debug and improvements
    * correct SQL model

### V0.2.6 DEBUG

* cleanup admin page
    * add o-panel component, responsive grid layout
    * add more vue components

* debug and improvements
    * upgrade SQL model

### V0.2.7 MULTIDOMAIN

* add os::run method to run an array of callable
    * hooks by path to allow plugins to add their own callables
* add multi-domain config to allow separate data folders per domain

* debug and improvements
    * admin sidebar menu 
    * move data from o-crud component to o-commix component to separate MVC

### V0.2.8 UPLOAD

* uploads from different domains are stored in different folders
* BUT if you want to mix uploads from different domains
    * you can use the same upload folder
    * and name the file with md5 hash signature of the content
    * no more duplicate files ;-p
    * but keep original extension for easier browsing  

* debug and improvements
    * add template slide.php
    * add Vue form upload 
    * add Roboto Mono font

### V0.2.9 VIDEO BYTE RANGE

* PHP local web server doesn't support Byte Range requests on static files
    * create a PHP template to serve video files
    * https://github.com/rvflorian/byte-serving-php
    * add class bysteserver to serve video files Byte Range requests

* HTML and JS video API needs Byte Range requests to stream video dynamically
    * video.currentTime
    * https://developer.mozilla.org/en-US/docs/Web/HTTP/Range_requests
    * https://developer.mozilla.org/en-US/docs/Web/API/HTMLMediaElement

