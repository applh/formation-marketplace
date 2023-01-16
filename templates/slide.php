<?php

$page = $_REQUEST["page"] ?? "";

$frame = intval($_REQUEST["frame"] ?? "");
$frame_max = $_REQUEST["frame_max"] ?? 900;
$scale = 1 + 2 * round(1 - ($frame / $frame_max), 3);
$scrollup = 0 - 2 * $frame;

// load json file from path data pages/playwright.json
$path_data = os::v("path_data");
$json = file_get_contents("$path_data/pages/$page.json");
// decode json to array
$page_content = json_decode($json, true);
if (is_array($page_content)) 
    extract($page_content);

$sections ??= [];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? "" ?></title>
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
        html, body {
            margin: 0;
            padding: 0;
            font-family: monospace;
            width:100%;
            height:100%;
            font-size: 16px;
            font-family: 'Roboto', sans-serif;
            font-weight: 100;
            background-color: <?php echo $bg_color ?? "#000" ?>;
        }
        * {
            box-sizing: border-box;
        }
        h1, h2, h3, h6 {
            text-align: left;
            z-index:10;
            position: relative;
            color:#e91e63;
            text-shadow: #333 0 0 10px;
            font-size: 2rem;
            font-weight: 200;
            padding-left: 2rem;
        }
        h1 {
            text-align: center;
            font-size: 4rem;
            color:#fff;
        }
        h2 {
            max-width: 50%;
        }
        img {
            width: 100%;
            object-fit: cover;
            aspect-ratio: 2 / 1;
        }
        footer {
            position: fixed;
            bottom: 0;
            left:0;
            width: 100%;
            /* background-color: rgba(0, 0, 0, 0.5); */
            /* gradient vertical */
            background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0), rgba(0, 0, 0, 1));
            color: #fff;
            text-align: right;
            z-index:100;
        }
        footer h3 {
            text-align: right;
            padding-right: 2rem;
            padding-top: 2rem;
            font-size:1rem;
        }
        p {
            text-align: left;
            display: block;
            font-size: 2.4rem;
            padding: 2rem;
            /* background-color: rgba(0, 0, 0, 0.5); */
            background-image: linear-gradient(to right, rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0));

            color:#fff;
            z-index:10;
            position: relative;

        }
        @media print {
            @page {
                size: A4;
                margin: 0;
            }
            /* add a page break for each section */
            section {
                page-break-after: always;
            }

        }

        img.slide {
            transform: scale(<?php echo $scale ?>);
            z-index:1;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .scrollup {
            position: relative;
            top: <?php echo $scrollup ?? 0 ?>px;
            left: 0;
            z-index: 10;
            background-image: linear-gradient(to right, rgba(0, 0, 0, 1), rgba(0, 0, 0, 0));
            padding-top: 10rem;
            padding-bottom: 100vmax;
        }
        .scrollup h2 {
            /* rotate -4 degrees */
            transform: rotate(-4deg);
            padding-left: 8rem;
            font-size: 4rem;;
        }
        img.square {
            object-fit: contain;
            aspect-ratio: initial;
        }
        .scrollup p, .scrollup img.square {
            width: 60vw;
        }
    </style>
</head>
<body>
    <main>
        <img class="slide" src="<?php echo $img ?? "/assets/media/photo-1.jpg" ?>" alt="">
        <div class="scrollup">
            <h1><?php echo $h1 ?? "" ?></h1>
            <?php foreach($sections as $section): ?>
                <section>
                    <h2><?php echo $section["title"] ?? "" ?></h2>
                    <p><?php echo $section["text"] ?? "" ?></p>
                    <?php if ($section["media"] ?? false): ?>
                        <img class="square" src="<?php echo $section["media"] ?? "" ?>" alt="">
                    <?php endif ?>
                </section>
            <?php endforeach ?>
        </div>
    </main>
    <footer>
        <h3><?php echo (1 + ($frame ?? 0)) ?></h3>
    </footer>
</body>
</html>