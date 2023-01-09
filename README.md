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

### V0.0.1

```
.
└── marketplace
    ├── LICENSE
    ├── README.md
    └── public
        └── index.php

```

### V0.0.2

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

# V0.0.3

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
```

## CREDITS

* Thanks to Pexels for the free images

