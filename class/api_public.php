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
        $data = [];
        $errors = [];

        // sanitize data
        $data['name'] = trim(strip_tags($_REQUEST['name'] ?? ""));
        $data['email'] = trim(strip_tags($_REQUEST['email'] ?? ""));
        $data['message'] = trim(strip_tags($_REQUEST['message'] ?? ""));

        // validate data
        if (!$data['name']) {
            $errors["name"] = "Name is required";
        }
        if (!$data['email']) {
            $errors["email"] = "Email is required";            
        }
        else if ($data['email'] !== filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            // check email is valid
            $errors["email"] = "Email is not valid";
        }

        if (!$data['message']) {
            $errors["message"] = "Message is required";
        }

        // if errors, return them
        if ($errors) {
            web::extra("errors", $errors);
            web::extra("feedback", "Error(s)... " . implode(", ", $errors));

            return;
        }

        // add timestamp
        $data['created'] = $now;
        // add ip 
        $data['ip'] = $_SERVER['REMOTE_ADDR'] ?? "";
        // add user agent
        $data['user_agent'] = $_SERVER['HTTP_USER_AGENT'] ?? "";
        
        // create local variables from array
        extract($data);

        // save in file
        $datajs = json_encode($data, JSON_PRETTY_PRINT);
        $file = framework::$root . "/my-data/form-contact.txt";
        file_put_contents($file, $datajs, FILE_APPEND);

        // create a new line in database
        model::create("contact", $data);

        // send email
        // TODO: add configuration parameters to my-config.php
        $to = os::v("admin/email") ?? "";

        if ($to) {
            $subject = "Contact Form ($name) $email";

            $message = 
            <<<txt
            Name: $name
            Email: $email
            Message: $message
            Timestamp: $now
            IP: $ip
            User Agent: $user_agent
    
            txt;
    
            $headers =
            <<<txt
            From: {$data['email']}
            Reply-To: {$data['email']}
            
            txt;
    
            // need a mail server to really send the email
            mail($to, $subject, $message, $headers);
    
        }

        web::extra("feedback", "Many Thanks. Your message was sent successfully... ($now, $name, $email)");
    }

    static function posts ()
    {
        $posts = model::read("post", "post", "path");
        web::extra("posts", $posts);
    }

    //_class_end_
}

//_file_end_
