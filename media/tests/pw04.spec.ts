import { test, expect, firefox } from '@playwright/test';

import { my_config } from './my-config';

let url_target = my_config.url_target ?? 'http://localhost:9876/test';

const shell = require('shelljs');
// const fs = require('fs');

// get the folder of the current test file
const testFolder = __dirname;

// PDF viewport
let viewport_PDF = {
    width: 1280,
    height: 1280,
    deviceScaleFactor: 1,
    isMobile: false,
    hasTouch: false,
    isLandscape: false,
};

let viewport_YOUTUBE = {
    width: 1680,
    height: 2160,
    deviceScaleFactor: 1,
    isMobile: false,
    hasTouch: false,
    isLandscape: false,
};

let viewport_YT_1920 = {
    width: 1920,
    height: 1920,
    deviceScaleFactor: 1,
    isMobile: false,
    hasTouch: false,
    isLandscape: false,
};

let viewport_YT_2160 = {
    width: 2160,
    height: 2160,
    deviceScaleFactor: 1,
    isMobile: false,
    hasTouch: false,
    isLandscape: false,
};

test.use({
    viewport: viewport_YT_2160,
    ignoreHTTPSErrors: true,
});

function mytime() {
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


test('localhost cv print', async ({ page }) => {

    let base_url = 'http://localhost:9876';    

    console.log(my_config.base_url);
    base_url = my_config.base_url ?? base_url;

    console.log(base_url);

    let api = await fetch(base_url + '/api');
    let json = await api.json();
    console.log(json);

    await page.goto(url_target);

    // get time in format YYMMDD-HHMMSS
    let time3 = mytime();

    // will create a folder if it does not exist
    let path_pdf = testFolder + '/localhost/localhost-' + time3 + '.pdf';
    let path_png = testFolder + '/localhost/localhost-' + time3 + '.png';

    // save screenshot
    await page.screenshot({
        path: path_png,
        fullPage: true,
    });
    console.log(path_png);

    // save pdf 
    // await page.pdf({ path: testFolder + '/localhost-' + time + '.pdf', format: 'A4' });
    await page.pdf({
        path: path_pdf,
        width: '1280',
        height: '1280',
    });
    console.log(path_pdf);


});


async function save_screenshot (page, frame_start, nb_frames = 100, frame_max = 900)
{
    for (let i = frame_start; i < frame_start + nb_frames; i++) {
        await page.goto(url_target + '?frame=' + i + '&frame_max=' + frame_max);
        let path_png = testFolder + '/localhost/frames/localhost-' + i + '.png';

        // save screenshot
        await page.screenshot({
            path: path_png,
            // fullPage: true,
        });
        console.log(path_png);

    }

}

test('localhost frames video 600 hello', async ({ page }) => {

    let now = mytime();
    let frame_start = 0;
    let frame_max = 1800;
    let nb_frames = frame_max - frame_start;

    test.setTimeout(nb_frames * 1000);

    await save_screenshot(page, frame_start, nb_frames, frame_max);
});

test('localhost youtube video 600 hello', async ({ page }) => {
    test.setTimeout(120000);

    let now = mytime();
    // launch shell command to build the video from the frames
    // ffmpeg -framerate 30 -i localhost-%d.png -c:v libx264 -profile:v high -crf 20 -pix_fmt yuv420p out.mp4
    // ffmpeg -framerate 30 -i localhost-%d.png -c:v libx264 -profile:v high -crf 20 -pix_fmt yuv420p out.mp4
    let cmd = `ffmpeg -framerate 30 -i localhost-%d.png -c:v libx264 -profile:v high -crf 20 -pix_fmt yuv420p ../out-${now}.mp4`
    console.log(cmd);

    shell.exec(cmd, { cwd: testFolder + '/localhost/frames' });
});

/**
 * warning: not working with chromium
 * firefox ok
 */
test('localhost video js t4', async ({ page }) => {

    const browser = await firefox.launch({
    //        executablePath: `/Applications/Google Chrome.app/Contents/MacOS/Google Chrome`,
    });

    let url_page = 'http://localhost:9876/video?json=pages/happy-new-year-2023.json';
    // let url_page = 'http://localhost:9876/video';
    // let url_page = 'https://www.youtube.com/watch?v=d_QeJZWurnk';
    let subfolder = 't4';

    page = await browser.newPage();

    await page.goto(url_page);
    // await page.getByRole('button').click();
    // await page.getByText('CLICK').click({ force: true });
    // let b1 = page.getByText('Accept all');
    // await b1.waitFor();
    // b1.click({ force: true });

    // let bplay = page.locator('button.ytp-play-button');
    // await bplay.waitFor();
    // bplay.click({ force: true });

    const vid = page.locator('#my-video');
    await vid.waitFor();

    let now = mytime();

    const slide = await page.evaluate(() => window.slide ?? {});
    let nb_frames = slide.nb_frames ?? 600;
    test.setTimeout(nb_frames * 10000);


    for(let i = 0; i < nb_frames; i++) {
        let path_png = testFolder + `/localhost/${subfolder}/localhost-${i}.jpg`;
        // save screenshot
        await page.screenshot({
            path: path_png,
            format: 'jpeg',
            quality: 100,
            // fullPage: true,
        });
        console.log(path_png);

        let frame_wait = await page.evaluate(async () => {
            let frmn = window.frame_next();
            // wait 1s max
            let nb_wait = 0;
            for (let i = 0; i < 20; i++) {
                nb_wait++;
                if (window.frame_ok) {
                    break;
                }
                await new Promise(r => setTimeout(r, 50));
            }
            return nb_wait;
        });
        console.log('frame wait:', frame_wait);
    }

    let cmd = `ffmpeg -framerate 30 -i localhost-%d.jpg -c:v libx264 -profile:v high -crf 20 -pix_fmt yuv420p ../out-${now}.mp4`
    console.log(cmd);

    shell.exec(cmd, { cwd: testFolder + '/localhost/' + subfolder });

    console.log(testFolder + '/localhost/' + `out-${now}.mp4`);

    if (slide.music) {
        let cmd = `ffmpeg -i ../out-${now}.mp4 -i ../../music/${slide.music} -c copy -map 0:v:0 -map 1:a:0 ../out-${now}-music.mp4`
        console.log(cmd);
        shell.exec(cmd, { cwd: testFolder + '/localhost/' + subfolder });
        console.log(testFolder + '/localhost/' + `out-${now}-music.mp4`);

    }
});
