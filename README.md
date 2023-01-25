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

OR

php framework.php web 9876

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


### V0.3.0 MEMBER AREA

* Admin area can be a bit messy as admins can do everything
* Member area is a very important as it's the public face of your app
  * To build a strong community quickly
  * Member area is the place where you can monetize your app
  * Member area is the place where you can build a strong community
  * Member area must be easy to use and understand
  * Member area must be easy to customize
  * Member area must be easy to extend
  * Member must be secured and performant

* debug and improvements
    * add template member.php
    * add Vue form login
    * add Vue form register
    * add Vue form forgot password
    * add Vue form reset password
    * add Vue form profile
    * add Vue form logout
    * add Vue form delete account
    * add Vue form change password
    * add Vue form change email
    * add Vue form change username
    * add Vue form change avatar
    * add Vue form change cover
    * add Vue form change bio
    * add Vue form change location
    * add Vue form change website
    * add Vue form change birthday

# V0.3.1 VIDEO SLIDEHOW TEMPLATE

* add better background video frame animation
  * tip: after updating video.currentTime, wait for video.canplaythrough event
  * video image is not updated immediately after video.currentTime update
  * wait can take x10ms to x100ms depending on video size and browser
    * https://developer.mozilla.org/en-US/docs/Web/API/HTMLMediaElement/canplaythrough_event


# V0.3.2 VIDEO SLIDEHOW TEMPLATE

* add json data to video slideshow template

# V0.3.3 MEMBER AREA

* add member page forms: register and login

# V0.3.4 MEMBER AREA

* refactor js modules in PHP template mjs.php
* add subfolders compos and forms for vue components modules and forms modules
* form front and back are centralized in the db table geocms with path `form`and `form/input`




## CREDITS

* Thanks to Pexels for the free images and videos
* Thanks to Lorem Picsum for the free images


