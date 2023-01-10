<?php
/**
 * class: api_public
 * created: 2023-01-10 18:53:03
 * license: MIT
 * author: appLH
 */

/**
 * api_public
 */
class api_public 
{
    //_class_start_

    static function contact ()
    {
        $now = date("Y-m-d H:i:s", web::$timestamp);
        // save request and append to file my-data/form-contact.txt
        $file = framework::$root . "/my-data/form-contact.txt";
        $data = [];
        // sanitize data
        $data['name'] = strip_tags($_REQUEST['name'] ?? "");
        $data['email'] = strip_tags($_REQUEST['email'] ?? "");
        $data['message'] = strip_tags($_REQUEST['message'] ?? "");

        // add timestamp
        $data['timestamp'] = $now;
        // add ip 
        $data['ip'] = $_SERVER['REMOTE_ADDR'] ?? "";
        // add user agent
        $data['user_agent'] = $_SERVER['HTTP_USER_AGENT'] ?? "";
        
        $data = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents($file, $data, FILE_APPEND);

        web::extra("feedback", "Many Thanks. Your message was sent successfully... ($now)");
    }

    static function posts ()
    {
        web::extra("posts", model::$posts);
    }

    //_class_end_
}

//_file_end_
