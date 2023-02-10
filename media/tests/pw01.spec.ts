import { test, expect, firefox } from '@playwright/test';

import { center } from './center';

let url_target = center.url_targets.pw01 
                ?? center.url_target 
                ?? 'http://localhost:9876/test';

const testFolder = __dirname;



test.use({
    viewport: center.viewports.PDF,
    ignoreHTTPSErrors: true,
});


// launch test from parent folder
// npx playwright test pw01 -g "p5js" --browser=firefox
// npx playwright test --browser=firefox --headed --workers=1 --reporter=list --timeout=0 --retries=0 --verbose --config=media/tests/pw01.config.ts media/tests/pw01.spec.ts
test('p5js', async ({ page }) => {

    let now = center.mytime();
    let frame_start = 0;
    let frame_max = 600;
    let nb_frames = frame_max - frame_start;

    center.test_folder = testFolder + '/my-localhost-' + now;

    center.test_url = url_target

    test.setTimeout(nb_frames * 1000);
    await center.save_screenshot(page, frame_start, nb_frames, frame_max);

    center.build_movie(now, 'p5js')
});
