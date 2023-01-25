<?php
// send a js module
// can be dynamic with GET parameters
// advantages: can send js code to browser
// warning: js modules are loaded only once by browser
// so the module js code will be executed only once
// json can only send data
// (trick with json: insert js code in script tag to execute inside browser...)

$forms = [];
$active = os::filename_cleanup($_GET["form"] ?? "");
$compo = os::filename_cleanup($_GET["compo"] ?? "");

if ($compo) {
    // check if file exists in compos dir
    $file = __DIR__ . "/compos/$compo.js";
    if (file_exists($file)) {
        // header content-type text/javascript
        header("Content-Type: text/javascript;");
        // send file content
        echo file_get_contents($file);
    }
}

if ($active) {
    // load the form infos
    $form_infos = model::read("geocms", $active, "filename");
    //error_log(json_encode($form_infos, JSON_PRETTY_PRINT));

    // build form infos
    $inputs = [];
    foreach($form_infos as $form_info) {
        // if path is form/input then add input to form
        extract($form_info);
        $path ??= "";
        if ($path == "form") {
            $form_title = $title ?? "";
            $form_process = $code ?? "";
        }

        if ($path == "form/input") {
            unset($value);
            extract(json_decode($code ?? "{}", true));
            $input = [
                "name" => $name ?? "",
                "type" => $type ?? "text",
                "label" => $label ?? "",
                "placeholder" => $placeholder ?? "",
                "required" => $required ?? false,
                "value" => $value ?? "",
            ];
            $inputs[] = $input;
        }
    }

    $form_active = [
        "title" => $form_title ?? $active,
        "inputs" => $inputs,
        "process_response" => $form_process ?? "",
    ];

    // header content-type text/javascript
    header("Content-Type: text/javascript;");

    include(__DIR__ . "/forms/module-js.php");


}


