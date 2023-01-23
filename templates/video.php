<?php

// retrieve video filename
$video = $_REQUEST["src"] ?? "/byterange?src=/assets/media/video-01.mp4";
$json = $_REQUEST["json"] ?? "";
if ($json) {
    $json = os::path_cleanup($json);
    $path_data = os::v("path_data");
    $path_json = "$path_data/$json";
    if (file_exists($path_json)) {
        $json_code = file_get_contents($path_json);
        $contents = json_decode($json_code, true);
        if (is_array($contents)) {
            extract($contents);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video</title>
    <style>
        /* latin-ext */
        @font-face {
            font-family: 'Roboto';
            font-style: normal;
            font-weight: 100;
            font-display: swap;
            src: url(/assets/Roboto_Mono/Roboto_Mono-Light.ttf) format('ttf');
            unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }

        /* latin */
        @font-face {
            font-family: 'Roboto';
            font-style: normal;
            font-weight: 100;
            font-display: swap;
            src: url(/assets/Roboto_Mono/Roboto_Mono-Light.ttf) format('ttf');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }

        /* latin-ext */
        @font-face {
            font-family: 'Roboto';
            font-style: normal;
            font-weight: 300;
            font-display: swap;
            src: url(/assets/Roboto_Mono/Roboto_Mono-Light.ttf) format('ttf');
            unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }

        /* latin */
        @font-face {
            font-family: 'Roboto';
            font-style: normal;
            font-weight: 300;
            font-display: swap;
            src: url(/assets/Roboto_Mono/Roboto_Mono-Light.ttf) format('ttf');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }

        /* latin-ext */
        @font-face {
            font-family: 'Roboto';
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: url(/assets/Roboto_Mono/Roboto_Mono-Light.ttf) format('ttf');
            unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }

        /* latin */
        @font-face {
            font-family: 'Roboto';
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: url(/assets/Roboto_Mono/Roboto_Mono-Light.ttf) format('ttf');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }

        /* latin-ext */
        @font-face {
            font-family: 'Roboto';
            font-style: normal;
            font-weight: 500;
            font-display: swap;
            src: url(/assets/Roboto_Mono/Roboto_Mono-Light.ttf) format('ttf');
            unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }

        /* latin */
        @font-face {
            font-family: 'Roboto';
            font-style: normal;
            font-weight: 500;
            font-display: swap;
            src: url(/assets/Roboto_Mono/Roboto_Mono-Light.ttf) format('ttf');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }

        /* latin-ext */
        @font-face {
            font-family: 'Roboto';
            font-style: normal;
            font-weight: 700;
            font-display: swap;
            src: url(/assets/Roboto_Mono/Roboto_Mono-Light.ttf) format('ttf');
            unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }

        /* latin */
        @font-face {
            font-family: 'Roboto';
            font-style: normal;
            font-weight: 700;
            font-display: swap;
            src: url(/assets/Roboto_Mono/Roboto_Mono-Light.ttf) format('ttf');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }

        /* latin-ext */
        @font-face {
            font-family: 'Roboto';
            font-style: normal;
            font-weight: 900;
            font-display: swap;
            src: url(/assets/Roboto_Mono/Roboto_Mono-Light.ttf) format('ttf');
            unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }

        /* latin */
        @font-face {
            font-family: 'Roboto';
            font-style: normal;
            font-weight: 900;
            font-display: swap;
            src: url(/assets/Roboto_Mono/Roboto_Mono-Light.ttf) format('ttf');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }
    </style>

    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            /* overflow: hidden; */
            width: 100%;
            height: 100%;
            font-size: 16px;
            font-family: 'Roboto', sans-serif;
        }

        * {
            box-sizing: border-box;
        }

        video {
            width: 100vw;
            height: 100vw;
            object-fit: cover;
            /* transform: scale(4); */
            position: fixed;
            top: 0;
            left: 0;
            z-index: 10;
            background-color: pink;
        }

        .hud {
            position: fixed;
            bottom: 0;
            right: 0;
            z-index: 99;
            background: rgba(200, 200, 200, 0.5);
            font-size: 1vw;
            padding: 0.5rem;
            cursor: pointer;
        }

        .slide {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            z-index: 20;
            padding: 20vmin 0 150vmax 0;
            /* gradient */
            background: linear-gradient(90deg, rgba(0, 0, 0, 1) 0%, rgba(0, 0, 0, 0) 100%);
        }

        section {
            padding-bottom: 4rem;
        }

        .slide h3 {
            font-size: 4vw;
            margin: 0;
            padding: 2rem;
            color: red;
            transform: rotate(-2deg);
            text-align: center;
            text-shadow: 0 0 0.25rem #000;
            display: block;
        }

        .slide p {
            font-size: <?php echo ($textsize ?? "2vw") ?>;
            margin: 0;
            padding: 2rem 4rem;
            color: white;
            text-align: left;
            background: <?php echo ($textbg ?? "linear-gradient(150deg, rgba(0, 0, 0, 0.5) 0%, rgba(0, 0, 0, 0) 70%) ") ?>;
            display: block;
            line-height: <?php echo ($lineheight ?? 1.5) ?>;
        }

        .slide img {
            display: block;
        }
        .slide h3, .slide p, .slide img {
            max-width: <?php echo ($slidewidth ?? '60vw') ?>;
        }
    </style>
</head>

<body>
    <video id="my-video" preload="auto">
        <source src="<?php echo $video ?>" type="video/mp4" />
        <h1>video format missing in your browser</h1>
    </video>

    <div class="slide">
        <?php foreach(($sections ?? []) as $section): ?>
            <?php 
                $titlestyle = $section["titlestyle"] ?? "";
                $mediastyle = $section["mediastyle"] ?? "";
                $textstyle = $section["textstyle"] ?? "";
                $media = $section["media"] ?? "";

                extract($section); 
            ?>
            <?php $ptext =  $text ?? implode("<br>", $lines ?? []) ?>
        <section>
            <h3 style="<?php echo $titlestyle ?>"><?php echo $title ?? "" ?></h3>
            <?php if ($media): ?>
                <img src="<?php echo $media ?>" alt="..." style="<?php echo $mediastyle ?>">
            <?php endif ?>
            <p><?php echo $ptext ?? "" ?></p>
        </section>
        <?php endforeach ?>
    </div>

    <div class="hud">
        <span id="ct"></span>
        <span id="cpt">+</span>
    </div>
    <script type="module">
        let debug = <?php echo ($debug ?? 'false') ?>;
        let dy = <?php echo ($dy ?? 2) ?>;
        let scale = 8;
        let vid = document.getElementById("my-video");
        window.frame_ok = false;
        vid.addEventListener('canplaythrough', function() {
            console.log("canplaythrough");
            document.querySelector('#cpt').innerHTML = '🔥';
            window.frame_ok = true;
        });
        vid.addEventListener('waiting', (event) => {
            console.log('Video is waiting for more data.');
        });
        let nb_click = 0;

        vid.style.transform = 'scale(' + scale + ')';

        window.frame_next = function() {
            // let duration = Math.round(vid.duration);
            let duration = vid.duration;
            let nb_frames = Math.round(30 * duration);
            // console.log("go:" + vid.currentTime);
            let currentTime = ((duration * nb_click / nb_frames) % duration).toFixed(6);

            window.frame_ok = false;
            vid.currentTime = currentTime;
            document.querySelector('#cpt').innerHTML = '-';

            // console.log("go2:" + vid.currentTime);
            if (debug) 
                ct.innerHTML = [nb_click, nb_frames, scale, currentTime, duration].join(' / ');

            // reduce video scale by 0.1
            let scale2 = Math.max(1, scale - 0.5 * (nb_click / nb_frames)).toFixed(6);
            vid.style.transform = 'scale(' + scale2 + ')';
            scale = scale2;
            // console.log(nb_click, nb_frames, scale, vid.currentTime);
            console.log(vid.currentTime);

            // slide up by 1
            let slide = document.querySelector(".slide");
            let slide_top = Math.min(0, slide.offsetTop - 1);
            slide.style.top = Math.round(-nb_click * dy) + "px";

            nb_click++;

            return window.frame_ok;
        }

        let btn = document.getElementById("ct");
        btn.addEventListener('click', frame_next);

        window.video_play = function(rate = 30) {
            setInterval(frame_next, 1000 / rate);
        }

        // put json code in a global variable for playwright access
        window.slide = <?php echo($json_code  ?? "{}") ?>;

    </script>
</body>