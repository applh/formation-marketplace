<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/media/photo-1.jpg">
    <title>P5JS</title>
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            height: 100%;
            width: 100%;
            overflow: hidden;
        }

        h1 {
            text-align: center;
            margin: 0;
            padding: 0;
        }

        input {
            width: 100%;
        }
        video {
            width: 100%;
            height: auto;
            object-fit: cover;
        }
    </style>
</head>
<?php 

$frame_max = $_GET["frame_max"] ?? 100;

?>
<body>
    <main></main>
    <script src="/assets/p5js/p5.min.js"></script>
    <script src="/assets/p5js/ml5.min.js"></script>
    <script>
        let frame_max = <?php echo $frame_max ?>;

        // get windows width
        let w = window.innerWidth;
        let vid0 = null;
        window.frame_ok = false;

        function video_time (t) {
            // set video current time
            window.frame_ok = false;
            if (vid0) vid0.currentTime = t;
        }

        window.frame_next = function (step=1) {
            // set video current time
            window.frame_ok = false;
            progress.value = step + int(progress.value);
            let p = progress.value;
            if (vid0.duration) vid0.currentTime = (p * vid0.duration / frame_max) % vid0.duration;
        }

        function setup() {
            createCanvas(w, w, WEBGL);

            progress.addEventListener("change", function() {
                window.frame_ok = false;
                let v = progress.value;
                if (vid0) vid0.currentTime = (v * vid0.duration / frame_max) % vid0.duration;
            });


            vid = createVideo('/byterange?src=/assets/media/video-2.mp4', function() {
                if (vid0.duration) {
                    // set the video time
                    // video_time((progress.value * vid0.duration / frame_max) % vid0.duration);
                    console.log("video loaded", vid0.duration, vid0.currentTime);
                    frame_next(0); // init frame image
                }
            });

            vid.hide();
            vid.showControls();
            vid0 = document.querySelector("video");
            vid0.addEventListener('canplaythrough', function() {
                // console.log("canplaythrough");
                window.frame_ok = true;
            });

            p = createP('Hello world!');
            p.style('font-size', '10vmin');
            p.style('color', 'red');
            p.style('text-align', 'center');
            p.position(0, 300);

            frame_next(0); // init frame image
        }

        function draw() {
            let v = progress.value;
            let rate = windowWidth / frame_max * v
            background(2 * v);
            // colorMode(HSB, v, 100, 100);
            fill(2 * v, 100, 100, 160);

            // video
            let h = window.innerHeight;
            let w = vid.width * h / vid.height;
            let d = vid.duration() ?? 0;
            if (d) {

                // resize video width to window width
                // let w = window.innerWidth;
                // let h = vid.height * w / vid.width;

                // resize video height to window height

                // display video centered
                image(vid, -0.5*w, -0.5*h, w, h);

            }

            ellipse(rate-0.5*h, 0.3 * windowHeight, 300, 300);

            // text
            p.position(rate-0.5*h, 100);

            // 3D
            translate(rate-0.5*h, 0, 0);
            push()
            box(200, 200, 400);
            fill(2 * v, 200, 200, 200);
            plane(400, 400)
            pop()
        }

        let playing = false;

        function mousePressed() {
            // if (!playing) {
            //     vid.play();
            //     vid.time((mouseX / width) * vid.duration());
            //     let t = vid.time();
            //     console.log(t);
            //     playing = true;
            // } else {
            //     vid.pause();
            //     playing = false;
            // }
        }


        // https://p5js.org/reference/#/p5/resizeCanvas
        function windowResized() {
            resizeCanvas(windowWidth, windowWidth);
        }
    </script>
    <footer>
        <input type="range" min="0" max="<?php echo $frame_max ?>" id="progress" value="<?php echo $_GET["frame"] ?? 50 ?>">
        <h1>P5JS</h1>
    </footer>

</body>

</html>