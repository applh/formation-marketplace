console.log('o-panel.js loaded');

let panel_default = 
`
<div uk-grid uk-height-match>
    <header class="uk-width-1-1">
        <section class="uk-section">
            <div class="uk-container">
                <input class="uk-input" type="password" required placeholder="your admin api key" aria-label="your admin api key" v-model="admin_api_key">
                <button class="uk-button uk-button-default" @click.prevent="login">LOGIN</button>
            </div>
        </section>
    </header>
    <div class="uk-width-1-6">
        <o-sidebar></o-sidebar>
    </div>
    <div class="uk-width-1-3">
        <div class="uk-card uk-card-default uk-card-body">
            <h3 class="uk-card-title">Default</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        </div>
    </div>            
    <div class="uk-width-1-2">
        <div class="uk-card uk-card-default uk-card-body">
            <h3 class="uk-card-title">Default</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        </div>
    </div> 
    <div class="uk-width-1-2">
        <o-crud title="page" table="page"></o-crud>
    </div> 
    <div class="uk-width-1-2">
        <o-crud title="post" table="post"></o-crud>
    </div> 
    <div class="uk-width-1-2">
        <o-crud title="contact" table="contact"></o-crud>
    </div> 
    <div class="uk-width-1-2">
        <o-crud title="user" table="user"></o-crud>
    </div> 
    <div class="uk-width-1-2">
        <o-post></o-post>
    </div> 
    <div class="uk-width-1-2">
        <o-post-crud></o-post-crud>
    </div> 
    <div class="uk-width-1-2">
        <o-post-crud></o-post-crud>
    </div> 
    <div class="uk-width-1-2">
        <o-test></o-test>
        <o-test></o-test>
    </div> 
    <footer class="uk-width-1-1">
        <nav>
            <a href="/">home</a>
            <a href="/credits">credits</a>
            <a href="/#form-contact">contact us</a>
        </nav>
        <p>Your MarketPlace &copy; 2023</p>
        <section>
            <p>{{ center.api_feedback }}</p>
        </section>
    </footer>           
</div>
`


let template = 
`
<div class="panel">
    <div v-if="center.window_w > 2000">
        <h1>o-panel (+2000px)</h1>
        <p>{{ center.window_w + 'x' + center.window_h }}</p>
        ${panel_default}
    </div>
    <div v-else-if="center.window_w > 1500">
        <h1>o-panel (+1500px)</h1>
        <p>{{ center.window_w + 'x' + center.window_h }}</p>
        ${panel_default}
    </div>
    <div v-else-if="center.window_w > 1000">
        <h1>o-panel (+1000px)</h1>
        <p>{{ center.window_w + 'x' + center.window_h }}</p>
        ${panel_default}
    </div>
    <div v-else-if="center.window_w > 500">
        <h1>o-panel (+500px)</h1>
        <p>{{ center.window_w + 'x' + center.window_h }}</p>
        ${panel_default}
    </div>
    <div v-else">
        <h1>o-panel (-500px)</h1>
        <p>{{ center.window_w + 'x' + center.window_h }}</p>
        ${panel_default}
    </div>
</div>
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