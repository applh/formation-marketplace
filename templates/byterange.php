<?php

$path_root = os::v("root");

$file = trim($_REQUEST["src"] ?? "");
// sanitize the file name
if ($file) {
    error_log($file);
    $file = os::path_cleanup($file);
    error_log($file);

    byteserver::send("$path_root/public/$file");
}
