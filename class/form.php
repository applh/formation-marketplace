<?php
/**
 * class: form
 * created: 2023-01-23 16:57:44
 * license: MIT
 * author: appLH
 */

/**
 * form
 */
class form 
{
    //_class_start_

    static $forms = [
        "register" => [
            [
                "name" => "username",
                "type" => "text",
                "val" => "",
            ],
            [
                "name" => "email",
                "type" => "email",
                "val" => "",
            ],
            [
                "name" => "password",
                "type" => "password",
                "val" => "",
            ]
        ],
        "login" => [
            [
                "name" => "email",
                "type" => "email",
                "val" => "",
            ],
            [
                "name" => "password",
                "type" => "password",
                "val" => "",
            ]
        ]
    ];

    static function process ($form_name)
    {
        $infos = self::$forms[$form_name] ?? [];
        $inputs = [];
        foreach($infos as $info) {
            extract($info);
            $type ??= "text";
            $val ??= "";
            $name ??= "";
            $default ??= "";
            $options ??= [];
            if ($name != "") {
                $inputs[$name] = [
                    "val" => form::filter($_REQUEST[$name] ?? $default, $type, $options),
                    "info" => $info,
                ];
            }
        }

        // post process
        $cb = "form::process_$form_name";
        error_log($cb);
        os::run("form/process/before/$form_name");
        if (is_callable($cb)) {
            $cb($inputs);
        }
        os::run("form/process/after/$form_name");
    }

    static function process_login ($inputs)
    {
        // check if email already exists
        $email = $inputs["email"]["val"];
        $user1 = model::read1("user", $email, "email");
        // check password
        $password = $inputs["password"]["val"];
        $passhash = $user1["passhash"] ?? "";
        $ok = password_verify($password, $passhash);
        if ($ok) {
            // login ok
            web::extra("feedback", "login ok ($email)");
            // set user api key
            $admin_api_key = os::v("admin/api/key") ?? os::md5();
            $expiration_time = time() + 60 * 60 * 24 * 30; // 30 days
            $user_id = $user1["id"];
            $user_api_key = os::md5("$admin_api_key/$expiration_time/$user_id");
            web::extra("user_api_key", "$user_api_key/$expiration_time/$user_id");
            // fixme: filter user data to publish
            web::extra("user", $user1);
        }
        else {
            // login failed
            web::extra("feedback", "login failed ($email)");
        }
    }

    static function process_register ($inputs)
    {
        // error_log(json_encode($inputs));

        // check if email already exists
        $email = $inputs["email"]["val"];
        $user1 = model::read1("user", $email, "email");
        // check if username already exists
        $username = $inputs["username"]["val"];
        $user2 = model::read1("user", $username, "username");
        $errors = [];
        if ($user1) {
            // email already exists
            $errors[] = "email already exists ($email)";
            web::extra("feedback", "email already exists ($email)");
        }
        if ($user2) {
            // email already exists
            $errors[] = "username already exists ($username)";
        }

        if (count($errors) == 0) {
            // add user to db
            $password = $inputs["password"]["val"];
            $passhash = password_hash($password, PASSWORD_DEFAULT);

            $user = [
                "username" => $inputs["username"]["val"],
                "email" => $inputs["email"]["val"],
                "passhash" => $passhash,
                "created" => os::now(),
                "level" => 1,   // fixme: should be 0 before activation
            ];

            model::create("user", $user);
            web::extra("feedback", "user created ($email)");
        }
        else {
            $error_message = implode(", ", $errors);
            web::extra("feedback", "user not created: $error_message"); 
        }
    }

    static function filter ($input, $type="text", $options=[])
    {
        $res = $input;

        if ($type != "code") {
            // remove html tags
            $res = strip_tags($res);
            // remove extra spaces
            $res = trim($res);
        }
        // email sanitize
        if ($type == "email") {
            $res = filter_var($res, FILTER_SANITIZE_EMAIL);
        }
        // password is md5 format
        if ($type == "password") {
            // remove non alphanumeric characters
            $res = preg_replace("/[^a-zA-Z0-9]/", "", $res);
            // lowercase
            $res = strtolower($res);
        }
        return $res;
    }

    //_class_end_
}

//_file_end_
