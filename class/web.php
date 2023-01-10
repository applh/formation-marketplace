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

    static function json ()
    {
        // set timestamp
        self::$timestamp = time();

        $now = date("Y-m-d H:i:s", self::$timestamp);

        // get c and m from request
        $c = $_REQUEST['c'] ?? 'public';
        $m = $_REQUEST['m'] ?? '';
        $api_callback = "api_$c::$m";
        if (is_callable($api_callback)) {
            $api_callback();
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

    static function extra ($key, $value)
    {
        self::$extras[$key] = $value;
    }

    //_class_end_
}

//_file_end_
