<?php

// declare the class
class framework
{
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
        // pages
        $pages = [
            'index' => [
                'template' => 'home',
            ],
            'api' => [
                'template' => 'api',
            ],
        ];

        // make an associative array to better retrieve individual post
        $posts = [
            'post-1' => [
                'uri' => 'post-1',
                'template' => 'post',
                'title' => 'Post 1',
                'image' => 'https://picsum.photos/id/1/640/640.jpg',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            ],
            'post-2' => [
                'uri' => 'post-2',
                'template' => 'post',
                'title' => 'Post 2',
                'image' => 'https://picsum.photos/id/2/640/640.jpg',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            ],
            'post-3' => [
                'uri' => 'post-3',
                'template' => 'post',
                'title' => 'Post 3',
                'image' => 'https://picsum.photos/id/3/640/640.jpg',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            ],
            'post-4' => [
                'uri' => 'post-4',
                'template' => 'post',
                'title' => 'Post 4',
                'image' => 'https://picsum.photos/id/4/640/640.jpg',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            ],
        ];

        $root = __DIR__;

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
        $routes = $pages + $posts;
        $route = $routes[$filename] ?? [];
        $template = $route["template"] ?? "404";
        
        if ($template == "post") {
            $post = $posts[$filename] ?? [];
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
