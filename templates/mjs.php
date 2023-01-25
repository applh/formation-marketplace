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
    $form_infos = model::read1("geocms", "form/$active", "uri");
    //error_log(json_encode($form_infos, JSON_PRETTY_PRINT));
    $contents = json_decode($form_infos["content"] ?? "", true);

    $form_active = [
        "title" => $contents["name"] ?? $active,
        "inputs" => $contents["inputs"] ?? [],
        "process_response" => $form_infos["code"] ?? ""
    ];

    // header content-type text/javascript
    header("Content-Type: text/javascript;");

    include(__DIR__ . "/forms/module-js.php");


}


