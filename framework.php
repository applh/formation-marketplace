<?php

// declare the class
class framework
{
    static $root = __DIR__;
    static $class_dirs = [
        __DIR__ . "/class",
        __DIR__ . "/my-data/class",
    ];

    static function autoload($class)
    {
        // loop through the class directories
        foreach (framework::$class_dirs as $dir) {
            $file = "$dir/$class.php";
            if (file_exists($file)) {
                require $file;
                return;
            }
        }
    }

    static function run()
    {
        // setup class autoloader
        spl_autoload_register("framework::autoload");
        // setup core config
        $path_root = framework::$root;
        os::v("root", $path_root);

        // load the framework config file if exists
        $path_config = "$path_root/my-config.php";
        if (file_exists($path_config)) {
            include $path_config;
        }
        else {
            // launch framework install
            cli::install();
        }
        
        $path_data = os::v("path_data") ?? "$path_root/my-data";

        os::run("framework/run/path_data");

        os::v("db/sqlite/path", "$path_data/sqlite.db");

        // load the project config file if exists
        $path_config = "$path_data/config.php";
        if (file_exists($path_config)) {
            include $path_config;
        }

        if (is_callable("index::web")) {
            // web server mode
            web::server();
        } else {
            // cli mode
            cli::run();
        }
    }
}

// run the code
framework::run();
