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
            $content = web::input("content");
            $media = web::input("media");
            $template = web::input("template");
            $path = web::input("path");

            // create data array
            $data = array(
                "title" => $title,
                "content" => $content,
                "media" => $media,
                "template" => $template,
                "path" => $path,
            );

            // create post
            model::create("geocms", $data);

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
                $content = web::input("content");
                $media = web::input("media");
                $template = web::input("template");
                $path = web::input("path");

                // create data array
                $data = array(
                    "title" => $title,
                    "content" => $content,
                    "media" => $media,
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
                $cud_table = cms::cud_table($table);
                model::delete($cud_table, $id);

                web::extra("feedback", "deleted: $table ($id)");
            }

            // if action is create
            if ($action == "create") {

                // get inputs by form_inputs
                $inputs = [];
                foreach ($form_inputs as $input) {
                    $name = $input["name"];
                    $type = $input["type"];
                    // if type is file then get file
                    if ($type == "file") {
                        $val = web::input_file($name);
                    } else {
                        $val = web::input($name);
                    }
                    $inputs[$name] = $val;
                }
                // remove id if present
                unset($inputs["id"]);
                
                // media extra processing
                if ($table == "media") {
                    // if $inputs["uri"] is empty then copy $inputs["media"] to $inputs["uri"]
                    if ($inputs["uri"] == "") {
                        $inputs["uri"] = $inputs["media"];
                    }
                    // if $inputs["filename"] is empty then copy $inputs["media"] to $inputs["filename"]
                    if ("" == ($inputs["filename"] ?? "")) {
                        $inputs["filename"] = $inputs["media"];
                    }
                }

                $cud_table = cms::cud_table($table);
                // create item
                model::create($cud_table, $inputs);

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
                    $cud_table = cms::cud_table($table);
                    model::update($cud_table, $id, $inputs);
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

    static function form ()
    {
        // get action, table
        $action = web::input("action");
        // if action is create then create form
        if ($action == "create") {
            // get table
            $table = "form";
            // get model info
            $form_inputs = cms::get($table);
            // add form inputs to web extra
            web::extra("form_create", $form_inputs);

            // get inputs by form_inputs
            $inputs = [];
            foreach ($form_inputs as $input) {
                $name = $input["name"];
                $type = $input["type"];
                // if type is file then get file
                if ($type == "array") {
                    $val = web::input_array($name);
                } else {
                    $val = web::input($name);
                }
                $inputs[$name] = $val;
            }
            // remove id if present
            unset($inputs["id"]);
            $cud_table = cms::cud_table($table);

            $form_name = $inputs["form_name"];
            if ($form_name) {
                // for each input create item
                $contents = [
                    "name" => $form_name,
                ];
                $fields = [];
                foreach ($inputs["inputs"] as $index => $input) {
                    $name = "";
                    $type = "";
                    $infos = json_decode($input, true);
                    $fields[] = $infos;
                }
                $contents["inputs"] = $fields;
                // create item
                $data = array(
                    "path" => "form",
                    "filename" => $form_name,
                    "uri" => "form/$form_name",
                    "content" => json_encode($contents, JSON_PRETTY_PRINT),
                    "code" => $inputs["process_response"] ?? "",
                );
                model::create1($cud_table, "uri", "form/$form_name", $data);
            }
    }

    }

    //_class_end_
}

//_file_end_
