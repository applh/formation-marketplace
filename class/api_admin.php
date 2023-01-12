<?php

/**
 * class: api_admin
 * created: 2023-01-11 17:36:16
 * license: MIT
 * author: appLH
 */

/**
 * api_admin
 */
class api_admin
{
    //_class_start_

    static function test()
    {
        // debug
        web::extra("feedback", "api_admin::test()");
    }

    static function cud_post()
    {
        // get action
        $action = web::input("action");

        if ($action == "create") {
            // get input from form: title, description, image, template, path
            $title = web::input("title");
            $description = web::input("description");
            $image = web::input("image");
            $template = web::input("template");
            $path = web::input("path");

            // create data array
            $data = array(
                "title" => $title,
                "description" => $description,
                "image" => $image,
                "template" => $template,
                "path" => $path,
            );

            // create post
            model::create("post", $data);

            // debug
            web::extra("feedback", "post created");
        }

        // update
        if ($action == "update") {
            // get id
            $id = web::input("id", 0);
            // security: convert to int
            $id = intval($id);
            // if $id > 0 then update post
            if ($id > 0) {
                // get input from form: title, description, image, template, path
                $title = web::input("title");
                $description = web::input("description");
                $image = web::input("image");
                $template = web::input("template");
                $path = web::input("path");

                // create data array
                $data = array(
                    "title" => $title,
                    "description" => $description,
                    "image" => $image,
                    "template" => $template,
                    "path" => $path,
                );

                // update post
                model::update("post", $id, $data);

                // debug
                web::extra("feedback", "post updated ($id)");
            }
        }

        if ($action == "delete") {
            // get id
            $id = web::input("id", 0);
            // security: convert to int
            $id = intval($id);
            // if $id > 0 then delete post
            if ($id > 0) {
                // delete post
                model::delete("post", $id);

                // debug
                web::extra("feedback", "post deleted ($id)");
            }
        }

        // refresh posts
        $posts = model::read("post", "post", "path");
        web::extra("posts", $posts);
    }

    static function crud()
    {
        // get action, table
        $table = web::input("table");
        $action = web::input("action");

        if ($table != "") {
            // get model info
            $form_inputs = cms::get($table);

            // if action is delete then delete item
            if ($action == "delete") {
                $id = web::input("id");
                // security: convert to int
                $id = intval($id);
                // delete item
                model::delete($table, $id);

                web::extra("feedback", "deleted: $table ($id)");
            }


            // if action is create
            if ($action == "create") {
                // get inputs by form_inputs
                $inputs = [];
                foreach ($form_inputs as $input) {
                    $name = $input["name"];
                    $val = web::input($name);
                    $inputs[$name] = $val;
                }
                // remove id if present
                unset($inputs["id"]);
                
                // create item
                model::create($table, $inputs);

                web::extra("feedback", "created: $table");
            }

            // if action is update
            if ($action == "update") {
                // get inputs by form_inputs
                $inputs = [];
                foreach ($form_inputs as $index => $input) {
                    $name = $input["name"];
                    $val = web::input($name);
                    $inputs[$name] = $val;

                    // copy val to form_update
                    $form_inputs[$index]["val"] = $val;
                }
                // get the id
                $id = intval($inputs["id"] ?? 0);
                if ($id > 0) {
                    // update item
                    model::update($table, $id, $inputs);
                }

                web::extra("feedback", "updated: $table ($id)");
            }

            // add form inputs to web extra
            web::extra("form_create", $form_inputs);
            web::extra("form_update", $form_inputs);

            // refresh posts
            $items = model::read($table);
            web::extra("items", $items);
        }

    }
    //_class_end_
}

//_file_end_
