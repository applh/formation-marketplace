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

    // TODO: add better way to handle cud_tables
    static $cud_tables = [
        "post"  => "geocms",
        "page"  => "geocms",
    ];
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

    static function cud_table ($table)
    {
        // get cud_table from array
        return cms::$cud_tables[$table] ?? $table;
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
        "name" => "content",
        "label" => "content",
        "type" => "textarea",
        "val" => "",
    ],
    [
        "name" => "media",
        "label" => "media",
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

$model_page = [
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
        "name" => "content",
        "label" => "content",
        "type" => "textarea",
        "val" => "",
    ],
    [
        "name" => "media",
        "label" => "media",
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
        "val" => "page",
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

$model_contact = [
    [
        "name" => "id",
        "label" => "id",
        "type" => "number",
        "val" => "",
    ],
    [
        "name" => "path",
        "label" => "path",
        "type" => "text",
        "val" => "",
    ],
    [
        "name" => "name",
        "label" => "name",
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
        "name" => "message",
        "label" => "message",
        "type" => "text",
        "val" => "",
    ],
];

cms::add("page", $model_page);
cms::add("post", $model_post);
cms::add("user", $model_user);
cms::add("contact", $model_contact);

//_file_end_
