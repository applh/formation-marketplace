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
* V0.2.x read the [V0.1.x Coding-recipes](Coding-recipes-v2.md)


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

# V0.3.5 ADMIN FORM BUILDER

* add admin form builder
  * drag and drop fields order
  * add/remove fields
  * so easy with Uikit Sortable and Vue 😎
   
* simplify form infos in db table geocms
  * only one SQL line for complete form infos
  * content column is a JSON string
  * process_response in separated column code to keep easier coding

* debug and improvements
    * debug o-commix import (remove .js extension)
  
## CREDITS

* Thanks to Pexels for the free images and videos
* Thanks to Lorem Picsum for the free images


