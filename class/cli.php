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

    static function init_path_data () {
        header("X-Debug-init: init");
        $path_data = os::v("path_data");
        // if dir not exists then exec cli::install
        // error_log("path_data: $path_data");
        if (!file_exists($path_data)) {
            cli::install();
        }
    }

    static function install ()
    {
        $path_root = os::v("root") ?? dirname(__DIR__);

        // create my-config.php if not exists
        $path_config = "$path_root/my-config.php";
        if (!file_exists($path_config)) {
            $path_sample_config = framework::$root . "/media/sample-root-config.php";

            // read the content 
            // and change the placeholder YOUR_ADMIN_API_KEY with a random string
            $data = file_get_contents($path_sample_config);
            $data = str_replace("YOUR_ROOT_ADMIN_API_KEY", os::md5(), $data);
            file_put_contents($path_config, $data);
        }
        
        // create my-data folder
        $path_data = os::v("path_data") ?? dirname(__DIR__) . "/my-data";
        // set path_data if not exists
        os::v("path_data") ?? os::v("path_data", $path_data);

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
        $mode = os::v("cms/mode") ?? "dev";
        if ($mode == "prod") {
            $path_htaccess = framework::$root . "/public/.htaccess";
            if (!file_exists($path_htaccess)) {
                $path_wp_htaccess = framework::$root . "/media/wp.htaccess";
                copy($path_wp_htaccess, $path_htaccess);
            }    
        }

        // create my-data/config.php if not exists
        $path_config = $path_data . "/config.php";
        if (!file_exists($path_config)) {
            $path_sample_config = framework::$root . "/media/sample-config.php";

            // read the content 
            // and change the placeholder YOUR_ADMIN_API_KEY with a random string
            $data = file_get_contents($path_sample_config);
            $data = str_replace("YOUR_ADMIN_API_KEY", os::md5(), $data);
            file_put_contents($path_config, $data);
        }

        // create my-data/class folder if not exists
        $path_class = $path_data . "/class";
        if (!file_exists($path_class)) {
            mkdir($path_class);
            // make sure it is writable
            chmod($path_class, 0777);
        }

        // create my-data/templates folder if not exists
        $path_templates = $path_data . "/templates";
        if (!file_exists($path_templates)) {
            mkdir($path_templates);
            // make sure it is writable
            chmod($path_templates, 0777);
        }
        
        // create sqlite database if not exists
        $path_db = os::v("db/sqlite/path") ?? $path_data . "/sqlite.db"; ;

        if (!file_exists($path_db)) {
            sqlite::db_create();

            // add some lines in table post from media/pages.json
            $path_posts = os::v("root") . "/media/pages.json";
            if (file_exists($path_posts)) {
                $data = file_get_contents($path_posts);
                $posts = json_decode($data, true);
                foreach ($posts as $post) {
                    $post["path"] = "page";
                    $post["created"] = date("Y-m-d H:i:s");
                    $post["modified"] = date("Y-m-d H:i:s");
                    model::create("geocms", $post);
                }
            }

            // add some lines in table post from media/posts.json
            $path_posts = os::v("root") . "/media/posts.json";
            if (file_exists($path_posts)) {
                $data = file_get_contents($path_posts);
                $posts = json_decode($data, true);
                foreach ($posts as $post) {
                    $post["path"] = "post";
                    $post["created"] = date("Y-m-d H:i:s");
                    $post["modified"] = date("Y-m-d H:i:s");
                    model::create("geocms", $post);
                }
            }       
            
        }

    }

    static function web ()
    {
        // get parameter 3
        $port = cli::$args[2] ?? "9876";

        // launch PHP local web server with root as public
        $doc_root = os::v("root") . "/public";
        $command = "php -S localhost:$port -t $doc_root";
        $logs = [];
        $logs[] = "launch web server";
        $logs[] = "doc root: $doc_root";
        $logs[] = "command: $command";
        print_r($logs);
        passthru($command);

    }

    static function media_sync ()
    {
        // get parameter 3
        $data_dir = cli::$args[2] ?? "my-data";

        // list aff files in $path_data/uploads
        // and for each file, check if it exists a line in table media at column media
        // if not, create a line in table media
        $path_data = os::v("root") . "/$data_dir";
        os::set_path_data($path_data);
        print_r(os::$vars);

        $path_uploads = $path_data . "/uploads";
        $files = glob("$path_uploads/*.*");
        echo "files in $path_uploads: ";
        print_r($files);
        foreach ($files as $file) {
            // cleanup file name
            $basename = basename($file);
            // md5sum
            $md5sum = md5_file($file);

            $extension = os::extension_cleanup($basename);
            $file = os::filename_cleanup($basename);
            $basename2 = "$file.$extension";
            // if $basename is not equal to $basename2, rename the file
            if ($basename != $basename2) {
                $new_file = "$path_uploads/$basename2";
                rename("$path_uploads/$basename", $new_file);
                $basename = $basename2;
            }

            $row = model::read1("media", $basename, "media");
            if (!$row) {
                $data = [
                    "media" => $basename,
                    "path" => "media",
                    "filename" => $md5sum,
                    "created" => date("Y-m-d H:i:s"),
                    "modified" => date("Y-m-d H:i:s"),
                ];

                echo "create line in table media for file $basename";
                // print_r($data);

                model::create("geocms", $data);
            }
            else {

                echo "line already exists in table media for file $basename";
                // print_r($row);
                // update filename with md5sum
                $data = [
                    "filename" => $md5sum,
                    "modified" => date("Y-m-d H:i:s"),
                ];
                model::update("geocms", $row["id"], $data);
            }
        }
    }

    static function page_add ()
    {
        // get parameter 3
        $data_dir = cli::$args[2] ?? "my-data";

        // list aff files in $path_data/uploads
        // and for each file, check if it exists a line in table media at column media
        // if not, create a line in table media
        $path_data = os::v("root") . "/$data_dir";
        // setup path_data
        os::set_path_data($path_data);
        print_r(os::$vars);

        // get parameter 4
        $uri = cli::$args[3] ?? "page-" . uniqid();
        // get parameter 5
        $template = cli::$args[4] ?? "post";

        $title ??= $uri;
        // create a line in table geocms
        $data = [
            "path" => "page",
            "title" => $title,
            "uri" => $uri,
            "template" => $template,
            "created" => date("Y-m-d H:i:s"),
            "modified" => date("Y-m-d H:i:s"),
        ];
        $res = model::create1("geocms", "uri", $uri, $data);
        if (is_array($res)) {
            extract($res);
            echo 
            <<<txt

            page ($id) $uri found: http://localhost:9876/$uri

            txt;
        }
        else {
            <<<txt

            page ($id) $uri added: http://localhost:9876/$uri
            
            txt;
        }
    }

}