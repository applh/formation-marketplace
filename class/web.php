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
        // store $filename for later use
        os::v("web/server/filename", $filename);

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

    static function input_array ($name, $default = [])
    {
        $value = $_REQUEST[$name] ?? $default;
        return $value;
    }

    static function input_file ($name, $default = "")
    {
        $value = $default;
        $errors = [];

        // check if file is uploaded
        if ($_FILES[$name] ?? false) {
            $file = $_FILES[$name];
            extract($file);
            // will create $name, $type, $tmp_name, $error, $size
            if (count($errors) == 0) {
                if ($error != 0) {
                    $errors[] = "Error uploading file";
                }
            }

            // check file size
            if (count($errors) == 0) {
                if ($size > 1000000) {
                    $errors[] = "File size is too big";
                }
            }

            if (count($errors) == 0) {
                // if $name if not empty
                // parse file name to get extension
                if ($name) {
                    $ext = os::extension_cleanup($name);
                    // check if extension is allowed
                    $compressed_images = ["avif", "webp", "jpg", "jpeg", "png", "gif"];
                    $allowed = os::v("form/upload/extension/ok") ?? $compressed_images;
                    if (!in_array($ext, $allowed)) {
                        $errors[] = "File extension not allowed";
                    }
                    else {
                        // parse filename from name
                        $filename = os::filename_cleanup($name);
                        $basename_ok = "$filename.$ext";
                        error_log("basename_ok: $basename_ok");
                        // move file to $path_data/uploads
                        $path_data = os::v("path_data");
                        $path = "$path_data/uploads";
                        if (!file_exists($path)) {
                            mkdir($path, 0777, true);
                        }
                        $target = "$path/$basename_ok";
                        if (file_exists($target)) {
                            $errors[] = "warning: File already exists (overwrite)";
                        }

                        if (!move_uploaded_file($tmp_name, $target)) {
                            $errors[] = "Error moving file";
                        }
                        // if $target is an image, create a thumbnail
                        if (in_array($ext, $compressed_images)) {
                            $path_root = os::v("root");
                            $path_thumb = "$path_root/public/my-uploads";
                            if (!file_exists($path_thumb)) {
                                mkdir($path_thumb, 0777, true);
                            }
                            // create image from content
                            $image = imagecreatefromstring(file_get_contents($target));
                            // get image size
                            $width = imagesx($image);
                            $height = imagesy($image);

                            $size = os::v("form/upload/size/thumb") ?? 1920;
                            // limit size to original $width
                            $size = min($size, $width);

                            // calculate thumbnail size
                            $new_width = $size;
                            $new_height = floor($height * ($size / $width));
                            // create new image
                            $thumb = imagecreatetruecolor($new_width, $new_height);
                            // resize image
                            imagecopyresized($thumb, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                            // save thumbnail
                            $target_md5 = md5_file($target);

                            imageavif($thumb, "$path_thumb/$target_md5.avif");
                            imagewebp($thumb, "$path_thumb/$target_md5.webp");
                        }
 
                        // set $value to $basename_ok
                        $value = $basename_ok;
                    }
                }
            }
        }

        return $value;
    }

    //_class_end_
}

//_file_end_
