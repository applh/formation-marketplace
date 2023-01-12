<?php
/**
 * class: cms
 * created: 2023-01-12 17:01:19
 * license: MIT
 * author: appLH
 */

/**
 * cms
 */
class cms 
{
    //_class_start_

    static $models = [];

    static function add ($name, $model)
    {
        // add model to array
        self::$models[$name] = $model;
    }

    static function get ($name, $default = [])
    {
        // get model from array
        return self::$models[$name] ?? $default;
    }

    //_class_end_
}

// DEFAULT MODEL

$model_post = [
    [
        "name" => "id",
        "label" => "id",
        "type" => "number",
        "val" => "",
    ],
    [
        "name" => "title",
        "label" => "Title",
        "type" => "text",
        "val" => "",
    ],
    [
        "name" => "description",
        "label" => "Description",
        "type" => "textarea",
        "val" => "",
    ],
    [
        "name" => "image",
        "label" => "Image",
        "type" => "text",
        "val" => "https://picsum.photos/id/4/640/640.jpg",
    ],
    [
        "name" => "template",
        "label" => "Template",
        "type" => "text",
        "val" => "post",
    ],
    [
        "name" => "path",
        "label" => "Path",
        "type" => "text",
        "val" => "post",
    ],
];

$model_user = [
    [
        "name" => "id",
        "label" => "id",
        "type" => "number",
        "val" => "",
    ],
    [
        "name" => "username",
        "label" => "Username",
        "type" => "text",
        "val" => "",
    ],
    [
        "name" => "passhash",
        "label" => "passhash",
        "type" => "text",
        "val" => "",
    ],
    [
        "name" => "email",
        "label" => "Email",
        "type" => "email",
        "val" => "",
    ],
    [
        "name" => "role",
        "label" => "Role",
        "type" => "text",
        "val" => "user",
    ],
];

cms::add("post", $model_post);
cms::add("user", $model_user);

//_file_end_
