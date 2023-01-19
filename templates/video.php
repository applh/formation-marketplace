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
        html, body {
            margin: 0;
            padding: 0;
            overflow: hidden;
            width: 100%;
            height: 100%;
        }
        video {
            width: 100vw;
            height: 100vw;
            object-fit: cover;
            /* transform: scale(4); */
            position: relative;
            z-index: 10;
        }
        .hud {
            position: fixed;
            bottom:0;
            left:0;
            z-index: 99;
            background: rgba(200,200,200,0.5);
        }
    </style>
</head>

<body>
    <video id="my-video" preload="auto">
        <source src="<?php echo $video ?>" type="video/mp4" />
        <div>video format missing in your browser</div>
    </video>

    <div class="hud">
        <button onclick="go()">CLICK</button>
        <span id="ct">...</span>
    </div>
    <script>
    let scale = 10;
    let vid = document.getElementById("my-video");
    vid.style.transform = 'scale(' + scale + ')';

    function go ()
    {
        // console.log("go:" + vid.currentTime);
        vid.currentTime= (vid.currentTime + 0.1) % vid.duration;
        // console.log("go2:" + vid.currentTime);
        ct.innerHTML = vid.currentTime + ' / ' + Math.floor(vid.duration) + 's';

        // reduce vide scale by 0.1
        let scale2 = Math.max(1, scale - 0.1);
        vid.style.transform = 'scale(' + scale2 + ')';
        scale = Math.max(1, scale2);
        console.log(scale, vid.currentTime);
    }
    </script>
</body>