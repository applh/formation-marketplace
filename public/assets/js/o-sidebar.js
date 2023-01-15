let template = 
`
<section class="uk-section">
    <h1><a href="/admin">ADMIN</a></h1>
    <nav>
        <a href="/">home</a>
        <a href="/admin">admin</a>
    </nav>
    <div class="box-login">
        <!-- Vue will teleport posts here -->
    </div>
    <p>Current time: <?php echo $now; ?></p>
    <button class="uk-button uk-button-default uk-margin-small-right" type="button" uk-toggle="target: #offcanvas-usage">Open</button>

    <div id="offcanvas-usage" uk-offcanvas>
        <div class="uk-offcanvas-bar">

            <button class="uk-offcanvas-close" type="button" uk-close></button>

            <h3>Title</h3>

            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>

        </div>
    </div>
</section>
`


// mixins
// import { default as commix } from '/assets/js/o-commix.js';
// let mixins = [ commix.mixin ];
let commix = await import('/assets/js/o-commix.js');
let mixins = [ commix.default.mixin ]; // warning: must add .default


// vue js async component
export default {
    template,
    mixins,
}