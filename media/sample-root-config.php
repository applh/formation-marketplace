<?php

// domain config

// admin api key
os::v("root/admin/api/key", "YOUR_ROOT_ADMIN_API_KEY");

/*

// localhost config
$server_name = $_SERVER["SERVER_NAME"] ?? "";
if ($server_name == "localhost") {
    $host = $_SERVER["HTTP_HOST"];
    $path_root = os::v("root");
    $host_path_data = [];
    
    // get port from host
    // replace all non-alphanumeric characters with dash
    $target = preg_replace("/[^a-zA-Z0-9]/", "-", $host);
    $target = trim($target, "-");
    $host_path_data[$host] = "$path_root/my-$target";

    // custom host if needed
    $host_path_data["localhost:9876"] = "$path_root/my-localhost-9876";
    
    os::v("path_data", $host_path_data[$host] ?? "my-data");

    $extra_codes = [
        "init"  =>  "cli::init_path_data",
    ];
    os::v("framework/run/path_data", $extra_codes);
}

*/