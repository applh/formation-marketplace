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

* V0.x read the [V0.x Coding-recipes](Coding-recipes.md)

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

## CREDITS

* Thanks to Pexels for the free images
* Thanks to Lorem Picsum for the free images


