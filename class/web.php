<?php

/**
 * class: web
 * created: 2023-01-10 16:53:51
 * license: MIT
 * author: appLH
 */

/**
 * web
 */
class web
{
    //_class_start_
    static $extras = [];
    static $timestamp = 0;

    static function json()
    {
        // set timestamp
        self::$timestamp = time();

        $now = date("Y-m-d H:i:s", self::$timestamp);

        // get c and m from request
        $c = $_REQUEST["c"] ?? "public";

        //check access to api $c
        $access_callback = "control::$c";
        if (is_callable($access_callback)) {
            $access = $access_callback() ?? false;
            if ($access) {
                $m = $_REQUEST["m"] ?? '';
                $api_callback = "api_$c::$m";
                if (is_callable($api_callback)) {
                    $api_callback();
                }
            }
        }

        // PHP associative array
        $data = [
            "now" => $now,
            "feedback" => "api is ready ($now)",
            "request" => $_REQUEST,
        ];
        // add extras
        $data = array_merge($data, self::$extras);

        // important to set the content type to JSON
        header("Content-Type: application/json");
        // convert PHP array to JSON
        echo json_encode($data);
    }

    static function extra($key, $value)
    {
        self::$extras[$key] = $value;
    }

    static function server()
    {
        $root = os::v("root");

        $now = date("Y-m-d H:i:s");
        $uri = $_SERVER["REQUEST_URI"] ?? "";

        // get $path from $uri (no query string or fragment)
        extract(parse_url($uri));
        $path ??= "";

        /**
         * note: 
         * with PHP local server, url http://localhost:8000 will give $uri = "/"
         * with PHP local server, url http://localhost:8000/ will give $uri = "/"
         * and http://localhost:8000/index.php will give $uri = "/index.php"
         */

        $myuri = trim($path, "/");
        $myuri = $myuri ?: "index.php";

        // parse the uri
        extract(pathinfo($myuri));
        $filename ??= "";

        // default template
        $template = "";

        // if no template, search in files
        if (!$template) {
            model::load();
            $routes = model::$pages + model::$posts;
            $route = $routes[$filename] ?? [];
            $template = $route["template"] ?? "";
            $post = $route;
        }

        // if no template, search in db
        if (!$template) {
            $posts = model::read("geocms", $filename, "uri");
            $post = $posts[0] ?? [];
            $template = $post["template"] ?? "";
        }

        // if no template, use 404
        if (!$template) {
            $template = "404";
        }
        // debug to the header
        header("X-URI: $uri,$filename,$template");
        // check if $template contains "::"
        if (strpos($template, "::") !== false) {
            $template = trim($template);
            // debug header
            header("X-Template: $template");
            if (is_callable($template)) {
                $template();
            }
        }
        else {
            // check template as PHP file
            $template_path = "$root/templates/$template.php";

            if (file_exists($template_path)) {
                include $template_path;
            }
            else {
                // check in $path_data/templates
                $path_data = os::v("path_data");
                $template_path = "$path_data/templates/$template.php";
                if (file_exists($template_path)) {
                    include $template_path;
                }
            }
    
        }

    }

    static function input ($name, $default = "")
    {
        $value = $_REQUEST[$name] ?? $default;
        return $value;
    }
    
    //_class_end_
}

//_file_end_
