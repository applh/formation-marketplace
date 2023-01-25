console.log('o-panel.js loaded');

let panel_default = 
`
<div uk-grid uk-height-match>
    <header class="uk-width-1-1">
    </header>
    <div class="uk-width-1-6">
        <o-sidebar></o-sidebar>
    </div>
    <div class="uk-width-5-6" uk-grid uk-height-match uk-sortable>
        <div class="uk-width-1-2">
            <div class="uk-card uk-card-default uk-card-body">
                <h3 class="uk-card-title">Welcome</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            </div>
        </div>            
        <div class="uk-width-1-2">
            <div class="uk-card uk-card-default uk-card-body">
                <h3 class="uk-card-title">Infos</h3>
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
            <o-crud title="media" table="media"></o-crud>
        </div> 
        <div class="uk-width-1-1">
            <o-admin-form-builder></o-admin-form-builder>
        </div> 
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
        ${panel_default}
        <h3>o-panel (+2000px)</h3>
        <p>{{ center.window_w + 'x' + center.window_h }}</p>
    </div>
    <div v-else-if="center.window_w > 1500">
        ${panel_default}
        <h3>o-panel (+1500px)</h3>
        <p>{{ center.window_w + 'x' + center.window_h }}</p>
    </div>
    <div v-else-if="center.window_w > 1000">
        ${panel_default}
        <h3>o-panel (+1000px)</h3>
        <p>{{ center.window_w + 'x' + center.window_h }}</p>
    </div>
    <div v-else-if="center.window_w > 500">
        ${panel_default}
        <h3>o-panel (+500px)</h3>
        <p>{{ center.window_w + 'x' + center.window_h }}</p>
    </div>
    <div v-else">
        ${panel_default}
        <h3>o-panel (-500px)</h3>
        <p>{{ center.window_w + 'x' + center.window_h }}</p>
    </div>
</div>
`


// mixins
let commix = await import('/mjs?compo=o-commix');
let mixins = [ commix.default.mixin ]; // warning: must add .default

let methods = {
}

// vue js async component
export default {
    template,
    mixins,
    methods,
}