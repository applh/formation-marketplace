<?php

$src = $_GET["src"] ?? "";
// sanitize $src, remove non alphanumeric characters or "-" or .
$src = preg_replace("/[^a-zA-Z0-9\.\-]/", "", $src);

$id = $_GET["id"] ?? 0;
$id = intval($id);

// TODO: add sercurity check to protect against directory traversal
// and also protect user private files
if ($id > 0) {
    // get the media
    $line = model::read1("media", $id);
}
elseif ($src) {
    // get the media
    $line = model::read1("media", $src, "media");
}

// if media is not empty
if (!empty($line)) {
    // print_r($line);
    // get the media uri
    $uri = $line["uri"] ?? "";
    $media = $line["media"] ?? "";

    if ($media) {
        // check if media exists in upload folder
        $path_data = os::v("path_data");
        $path_uploads = "$path_data/uploads";
        $path_media = "$path_uploads/$media";
        if (file_exists($path_media)) {
            // get the media mime type
            $mime = mime_content_type($path_media);
            // set the header
            header("Content-Type: $mime");
            // read the file
            readfile($path_media);
        }
    }
}