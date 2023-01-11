<?php

class cli
{
    static $args = [];

    static function run ()
    {
        // debug: get args
        cli::$args = $_SERVER['argv'] ?? [];
        print_r(cli::$args);

        $arg1 = cli::$args[1] ?? "";
        // if $args contains ::, then call the function
        // else, call the method $arg1 in classs cli
        if (strpos($arg1, "::") !== false) {
            $command = $arg1;
        } else {
            $command = "cli::$arg1";
        }
        if (is_callable($command)) {
            $command();
        }
    }

    /**
     * php framework.php code myclass
     */
    static function code ()
    {
        $logs = [];
        $args2 = cli::$args[2] ?? "";
        if ($args2) {
            $logs[] = "code $args2";
            
            // target file
            $target = __DIR__ . "/$args2.php";
            if (!file_exists($target)) {
                $logs[] = "create class file: $target";
                // check if sample file exists
                // then get the code from it
                // replace =CREATED= with date
                // replace sample with $args2
                // then save the code to $target
                $sample = __DIR__ . "/sample.php";
                if (file_exists($sample)) {
                    $code = file_get_contents($sample);
                    $code = str_replace("=CREATED=", date("Y-m-d H:i:s"), $code);
                    $code = str_replace("sample", $args2, $code);
                    file_put_contents($target, $code);
                } else {
                    $logs[] = "sample file not found: $sample";
                }
            } else {
                $logs[] = "file exists: $target";
            }
        }
        print_r($logs);
    }

    static function install ()
    {
        // create my-data folder
        $path_data = framework::$root . "/my-data";
        if (!file_exists($path_data)) {
            mkdir($path_data);
            // make sure it is writable
            chmod($path_data, 0777);
        }

        // post data
        $path_posts = $path_data . "/posts.json";
        // if file not exists, create it
        // export the data from model::$posts in json format
        if (!file_exists($path_posts)) {
            $data = json_encode(model::$posts, JSON_PRETTY_PRINT);
            file_put_contents($path_posts, $data);
        }

        // page data
        $path_pages = $path_data . "/pages.json";
        // if file not exists, create it
        // export the data from model::$pages in json format
        if (!file_exists($path_pages)) {
            $data = json_encode(model::$pages, JSON_PRETTY_PRINT);
            file_put_contents($path_pages, $data);
        }

        // copy media/wp.htaccess to public/.htaccess if not exists
        $path_htaccess = framework::$root . "/public/.htaccess";
        if (!file_exists($path_htaccess)) {
            $path_wp_htaccess = framework::$root . "/media/wp.htaccess";
            copy($path_wp_htaccess, $path_htaccess);
        }
    }
}