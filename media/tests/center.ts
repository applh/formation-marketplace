let base_url = 'http://localhost:9876';

let mytime = function () {
    // get time in format YYMMDD-HHMMSS
    const date = new Date();
    const time2 = date.toISOString();
    // 2023-01-15T17:38:15.046Z
    console.log(time2);
    const time3 = time2
        .replace(/\..+/, '')
        .replace(/:/g, '')
        .replace(/-/g, '')
        .replace('T', '-');
    console.log(time3);
    return time3;
}

let save_screenshot = async function  (page, frame_start, nb_frames = 100, frame_max = 900)
{
    await page.goto(center.test_url + '?frame=' + frame_start + '&frame_max=' + frame_max);

    for (let i = frame_start; i < frame_start + nb_frames; i++) {

        let frame_wait = await page.evaluate(async () => {
            // change progressbar
            window.frame_next()
            // wait 1s max
            let nb_wait = 0;
            for (let i = 0; i < 30; i++) {
                nb_wait++;
                if (window.frame_ok) {
                    break;
                }
                await new Promise(r => setTimeout(r, 100));
            }
            return nb_wait;
        });
        // wait extra 100ms
        await new Promise(r => setTimeout(r, 100));

        console.log('frame wait:', frame_wait);

        let index = i.toString().padStart(4, '0');
        let path_png = center.test_folder + '/frames/localhost-' + index + '.jpg';

        // save screenshot
        await page.screenshot({
            path: path_png,
            format: 'jpeg',
            quality: 80,
            // fullPage: true,
        });
        console.log(path_png);

    }

}

const shell = require('shelljs');

let build_movie = function (subfolder, now) {
    let framerate = 30;
    let cmd = `ffmpeg -framerate ${framerate} -i frames/localhost-%4d.jpg -c:v libx264 -profile:v high -crf 20 -pix_fmt yuv420p ./out-${now}.mp4`
    console.log(cmd);

    shell.exec(cmd, { cwd: center.test_folder });

    console.log(center.test_folder + `/out-${now}.mp4`);

}

export const center = {
    base_url,
    url_api : base_url + '/api',
    url_target : base_url + '/print',
    url_targets : {
        pw01 : base_url + '/p5js',
        pw02 : base_url + '/test2',
    },
    test_url: '',
    test_folder: __dirname,
    viewports : {
        PDF : {
            width: 1280,
            height: 1280,
            deviceScaleFactor: 1,
            isMobile: false,
            hasTouch: false,
            isLandscape: false,
        },
        YOUTUBE : {
            width: 1680,
            height: 2160,
            deviceScaleFactor: 1,
            isMobile: false,
            hasTouch: false,
            isLandscape: false,
        },
    },
    mytime,
    save_screenshot,
    build_movie,
}
