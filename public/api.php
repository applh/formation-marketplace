<?php

$now = date("Y-m-d H:i:s");

// PHP associative array
$data = [
    "now" => $now,
    "feedback" => "api is ready ($now)",
    "request" => $_REQUEST,
];

// important to set the content type to JSON
header("Content-Type: application/json");
// convert PHP array to JSON
echo json_encode($data);
