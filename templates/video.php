<?php

// retrieve video filename
$video = $_REQUEST["src"] ?? "/byterange?src=/assets/media/video-01.mp4";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video</title>

    <style>
        video {
            width: 100%;
            height: auto;
        }
    </style>
</head>

<body>
    <video id="my-video" preload="auto">
        <source src="<?php echo $video ?>" type="video/mp4" />
        <div>video format missing in your browser</div>
    </video>

    <button onclick="go()">CLICK</button>
    <span id="ct">...</span>
    <script>
    function go ()
    {
        let vid = document.getElementById("my-video");
        // console.log("go:" + vid.currentTime);
        vid.currentTime= Math.floor((vid.currentTime +1) % vid.duration);
        // console.log("go2:" + vid.currentTime);
        ct.innerHTML = vid.currentTime + ' / ' + Math.floor(vid.duration) + 's';
    }
    </script>
</body>