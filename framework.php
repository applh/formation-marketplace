<?php

// declare the class
class framework
{
    static $root = __DIR__;

    static function autoload($class)
    {
        $file = __DIR__ . "/class/$class.php";
        if (file_exists($file)) {
            require $file;
        }
    }

    static function run()
    {
        // setup class autoloader
        spl_autoload_register("framework::autoload");

        if (is_callable("index::web")) {
            // web server mode
            framework::server();
        } else {
            // cli mode
            cli::run();
        }
    }

    static function server()
    {
        $root = framework::$root;

        $now = date("Y-m-d H:i:s");
        $uri = $_SERVER["REQUEST_URI"] ?? "";

        // note: 
        // with PHP local server, url http://localhost:8000 will give $uri = "/"
        // with PHP local server, url http://localhost:8000/ will give $uri = "/"
        // and http://localhost:8000/index.php will give $uri = "/index.php"

        $myuri = trim($uri, "/");
        $myuri = $myuri ?: "index.php";

        // parse the uri
        extract(pathinfo($myuri));
        $filename ??= "";

        // default template
        model::load();
        $routes = model::$pages + model::$posts;
        $route = $routes[$filename] ?? [];
        $template = $route["template"] ?? "404";
        
        if ($template == "post") {
            $post = $routes[$filename] ?? [];
            extract($post);
        }

        $template_path = "$root/templates/$template.php";
        // debug to the header
        header("X-URI: $uri,$filename,$template,$template_path");
        if (file_exists($template_path)) {
            include $template_path;
        }
    }
}

// run the code
framework::run();
