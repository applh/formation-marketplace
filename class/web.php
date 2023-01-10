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

    static function json ()
    {
        $now = date("Y-m-d H:i:s");

        // PHP associative array
        $data = [
            "now" => $now,
            "feedback" => "api is ready ($now)",
            "posts" => model::$posts,
            "request" => $_REQUEST,
        ];
        
        // important to set the content type to JSON
        header("Content-Type: application/json");
        // convert PHP array to JSON
        echo json_encode($data);
    }

    //_class_end_
}

//_file_end_
