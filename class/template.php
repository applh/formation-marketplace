<?php
/**
 * class: template
 * created: 2023-01-15 10:42:24
 * license: MIT
 * author: appLH
 */

/**
 * template
 */
class template 
{
    //_class_start_

    static function info ()
    {
        phpinfo();
    }

    static function json()
    {
        // set timestamp
        web::$timestamp = time();

        $now = date("Y-m-d H:i:s", web::$timestamp);

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
            "files" => $_FILES,
        ];
        // add extras
        $data = array_merge($data, web::$extras);

        // important to set the content type to JSON
        header("Content-Type: application/json");
        // convert PHP array to JSON
        echo json_encode($data);
    }

    //_class_end_
}

//_file_end_
