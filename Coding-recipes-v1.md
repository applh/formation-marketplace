# CODING RECIPES

## V0.1.x

### V0.1.0 ROUTER: ADD DYNAMIC ROUTING BY URI

* To get better SEO
* we migrate URLs to dynamic routing

```
/post-1
/post-2
/post-3
...
```

* With PHP local server, each URL without extension is sent to index.php

* With most Web Hosting, the Server stack is using Apache
* Apache can be configured to send each URL without file correspondance to index.php
    * You have to add a `.htaccess` file in the public folder of your project
    * We can use the WordPress `.htaccess` file as a template
    * https://fr.wordpress.org/support/article/htaccess/


#### CODE ORGANIZATION

* We don't need post.php anymore
* but index.php is now a double template in one file
    * for the home page
    * for the single post page
    * index.php is mixing a lot of code and responsabilities
        * html
        * php
        * javascript
* We now need to split the code in multiple files
    * to make it more readable
    * to make it more maintainable
    * to make it more scalable

        
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

### V0.1.1 ADD PHP CLASSES

* We need to split the code in multiple files
* to make it more readable
* to make it more maintainable
* to make it more scalable

* PHP has 2 powerful features to split code in multiple files
    * templates
    * classes

* Re-organize the code in multiple files
* Target MVC Structure
    * Model
    * View
    * Controller

* View
    * `index.php` and `api.php` are now templates
        * for better clarity `index.php` is renamed `home.php`
    * note: URL for API was `api.php` and is now `api`

#### PHP CLASS AUTOLOAD

* PHP has a very powerful feature to load classes automatically
    * better memory management
    * better performance
    * better scalability

* https://www.php.net/manual/en/function.spl-autoload-register.php

* Crazy things: PHP autoloader is a available since PHP5.1+ (2005)
* But other languages still don't have this feature 😱
    * JavaScript
    * Python
    * Java
    * ...

* Important: Setup PHP autoloader as soon as possible 🔥

#### PHP CLI

* PHP can also be used as a scripting language
* PHP can be used to create command line interface (CLI)
    * PHP can be used to automate tasks

#### CODE STRUCTURE

* One single entry point for the PHP server
    * `public/index.php`
* One single entry point for the PHP framework
    * `framework.php`
* 2 modes are possible to activate the framework
    * web server
    * command line interface (CLI)

* PHP files are organized in 3 folders
    * `class`
    * `templates`
    * `public`

```
.
└── marketplace
    ├── Coding-recipes.md
    ├── LICENSE
    ├── README.md
    ├── public
    │   ├── assets
    │   │   ├── css
    │   │   │   ├── site.css
    │   │   │   ├── uikit-rtl.css
    │   │   │   ├── uikit-rtl.min.css
    │   │   │   ├── uikit.css
    │   │   │   └── uikit.min.css
    │   │   ├── js
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
    ├── templates
    │   ├── api.php
    │   └── home.php
    └── class
        └── cli.php

8 directories, 20 files
```

### V0.1.2 ADD PHP CLASSES

* add cli command to create a new class
    * better coding standards

```
php framework.php code myclass
```

* re-organize the code in method `framework::server`
    * routes: pages + posts
    * each route has a template
* separate the templates home.php and post.php

#### PHP CODE STRUCTURE

* note: only PHP files

```
.
└── marketplace
    ├── public
    │   └── index.php
    ├── framework.php
    ├── class
    │   ├── cli.php
    │   └── sample.php
    └── templates
        ├── api.php
        ├── home.php
        └── post.php

```

### V0.1.3 ADD MODEL CLASS AND 404 TEMPLATE

* add web class and method web::json
    * to send json data to the client
* add model class
    * to manage data
    * to manage database

* load posts and pages from json files
    * posts are stored in `my-data/posts.json`
    * pages are stored in `my-data/pages.json`
    * 👍 Projects can now have their own data 
        * TODO: There's still lots of further work...

* add cli command cli::install
    * to create the `my-data` folder
    * to create the `my-data/posts.json` file
    * to create the `my-data/pages.json` file

* note: files or folders starting with `my-` are ignored by git
    * there's a `.gitignore` file in the root folder

```
php framework.php install
```

* add 404 template
    * `templates/404.php`

#### PHP CODE STRUCTURE

* MVC structure is emerging
    * Model `class/model.php`
    * View  `templates` and `class/web.php`
    * Controller `framework.php`

* note: only framework files

```
.
└── marketplace
    ├── public
    │   ├── assets
    │   └── index.php
    ├── framework.php
    ├── class
    │   ├── cli.php
    │   ├── model.php
    │   ├── sample.php
    │   └── web.php
    ├── my-data
    │   ├── pages.json
    │   └── posts.json
    └── templates
        ├── 404.php
        ├── api.php
        ├── home.php
        └── post.php
```

### V0.1.4 ADD CONTACT FORM + AJAX

* add UIkit + Vue contact form
* add Vue ajax to send the form
* add PHP api_public to process the form

* SECURITY: receivign data from outside can always be dangerous
    * TODO: sanitize and validate data (email, ...)
    * strip_tags
    * ...


#### PHP CODE STRUCTURE

```
.
├── my-data
│   ├── form-contact.txt
│   ├── pages.json
│   └── posts.json
├── public
│   ├── assets
│   └── index.php
├── framework.php
├── class
│   ├── api_public.php
│   ├── cli.php
│   ├── model.php
│   ├── sample.php
│   └── web.php
└── templates
    ├── 404.php
    ├── api.php
    ├── home.php
    └── post.php

```

### V0.1.5 CRUD AND SQLITE DATABASE

SQLite is a lightweight database engine
* no need to install a database server
* no need to configure a database server
* no need to create a database
* no need to create a database user
* no need to create a database password

* add SQLite database
    * `my-data/sqlite.db`
* add model class to manage the database
    * `class/model.php`
    * `class/sqlite.php`
* add cli command to create the database
    * `php framework.php install`

#### CRUD

* create
* read
* update
* delete

* CRUD is a common task
    * Github Copilot is a great tool to write code
    * https://copilot.github.com/
    * Copilot can write the code for you...

#### PHP CODE STRUCTURE

```
.
├── my-data
│   ├── form-contact.txt
│   ├── pages.json
│   ├── posts.json
│   └── sqlite.db
├── public
│   ├── assets
│   └── index.php
├── framework.php
├── class
│   ├── api_public.php
│   ├── cli.php
│   ├── model.php
│   ├── sample.php
│   ├── sqlite.php
│   └── web.php
└── templates
    ├── 404.php
    ├── api.php
    ├── home.php
    └── post.php

```

#### UBUNTU ROOT PDO SQLITE3 MODULE INSTALLATION

* some PHP modules are not installed by default
* you need to install them manually
* example: PDO SQLite3 module

```
apt-cache search php | grep sqlite
apt install php8.2-sqlite3
php -m | grep sqlite

# you should see in the list: pdo_sqlite3

```

#### VSCODE SQLITE3 EXTENSION

* install the SQLite extension for VSCode
* https://marketplace.visualstudio.com/items?itemName=alexcvzz.vscode-sqlite
* install the extension SQlite3 Editor
* https://marketplace.visualstudio.com/items?itemName=yy0931.vscode-sqlite3-editor


### V0.1.6 POST / READ FROM DB

* Re-organize the code
    * create space for custom code extensions
    * config file in `my-data/config.php`
    * more PHP classes can be added in folder `my-data/class/`

* add admin page
    * `templates/admin.php`
    

### V0.1.7 ADMIN PAGE

* admin page setup
    * add class api_admin
    * add class control to check admin/api/key
    * add general form to send request to api_admin

* debug/improvements
    * switch template home to db posts
    * add robots.php template
    * add favicon image
    * vue code cleanup
    * dynamic load_js by Vue

* fixme
    * remove json post/page loader ?

#### MVC COMPONENTS ARE HERE

* Model `class/model.php`
* View  `templates` and `class/web.php`
* Controller `framework.php`, `class/web.php` and `class/control.php`

#### CODE STRUCTURE

```
.
├── Coding-recipes.md
├── LICENSE
├── README.md
├── class
│   ├── api_admin.php
│   ├── api_public.php
│   ├── cli.php
│   ├── control.php
│   ├── model.php
│   ├── os.php
│   ├── sample.php
│   ├── sqlite.php
│   └── web.php
├── framework.php
├── media
│   ├── pages.json
│   ├── posts.json
│   ├── sample-config.php
│   └── wp.htaccess
├── my-data
│   ├── class
│   ├── config.php
│   ├── pages.json
│   ├── posts.json
│   └── sqlite.db
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
│   │   │   ├── site.js
│   │   │   ├── uikit-icons.js
│   │   │   ├── uikit-icons.min.js
│   │   │   ├── uikit.js
│   │   │   ├── uikit.min.js
│   │   │   └── vue.esm-browser.prod.min.js
│   │   └── media
│   │       └── photo-1.jpg
│   └── index.php
└── templates
    ├── 404.php
    ├── admin.php
    ├── api.php
    ├── home.php
    ├── post.php
    └── robots.php

11 directories, 40 files
```


### V0.1.8 ADMIN PAGE / CRUD ON POSTS

* quick version of CRUD on posts: only 1 form to do CUD
    * create (no id)
    * update (with id > 0)
    * delete (with id > 0)
* only one back method: `api_admin::cud_post`

* debug and improvements
    * add custom folder `my-data/templates`
    * add template `adminer.php`
    * https://www.adminer.org/en/extension/
    * (note: sqlite file is relative to `/public` if PHP local server is executed from `/public`)

#### ADMINER

* Adminer is a full-featured database management tool written in PHP
* Adminer is available for 
    * MySQL, PostgreSQL, SQLite, 
    * MS SQL, Oracle, Firebird, SimpleDB, 
    * Elasticsearch and MongoDB
    * ...

* Adminer is available as a PHP file ready to deploy to the target server
* Adminer is available as a single PHP file to be included in your application

* Crazy thing:
* SQLite database doesn't need user and password
* But Adminer needs user and password
    * HACK: override the method `login`
    * https://www.adminer.org/en/extension/


### V0.1.9 ADMIN PAGE / CRUD + ASYNC VUE COMPONENT

* add vue async component to admin page
    * simple setup of vue async component
    * tip: create a relation provide/inject between main app and child components

* debug and improvements
    * add command cli::web to launch PHP local web server

#### CODE STRUCTURE

```
.
├── media
├── my-data
├── public
│   ├── assets
│   │   ├── css
│   │   ├── js
│   │   │   ├── admin.js
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
