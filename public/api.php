<?php
// load framework
require __DIR__ . "/../framework.php";

$now = date("Y-m-d H:i:s");

// PHP associative array
$data = [
    "now" => $now,
    "feedback" => "api is ready ($now)",
    "posts" => $posts,
    "request" => $_REQUEST,
];

// important to set the content type to JSON
header("Content-Type: application/json");
// convert PHP array to JSON
echo json_encode($data);
