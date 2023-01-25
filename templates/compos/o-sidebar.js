let template =
    `
<div class="">
    <div class="uk-card uk-card-default uk-card-body">

        <h1><a href="/admin">ADMIN</a></h1>
        <nav>
            <a href="/">home</a>
            <a href="/admin">admin</a>
        </nav>
        <div>
            <input class="uk-input" type="password" required placeholder="your admin api key" aria-label="your admin api key" v-model="center.api_admin_key">
            <button class="uk-button uk-button-default" @click.prevent="login">LOGIN</button>
        </div>

    </div>

    <div class="uk-card uk-card-default uk-card-body">
        <ul class="uk-nav-default" uk-nav>
            <li class="uk-nav-header">CMS</li>
            <li><a href="#"><span class="uk-margin-small-right" uk-icon="icon: table"></span>Pages</a></li>
            <li><a href="#"><span class="uk-margin-small-right" uk-icon="icon: thumbnails"></span>Posts</a></li>
            <li class="uk-nav-divider"></li>
            <li><a href="#"><span class="uk-margin-small-right" uk-icon="icon: trash"></span>Contacts</a></li>
            <li class="uk-nav-divider"></li>
            <li><a href="#"><span class="uk-margin-small-right" uk-icon="icon: trash"></span>Users</a></li>
            <li class="uk-active"><a href="#">Options</a></li>
            <li class="uk-parent">
                <a href="#">Templates <span uk-nav-parent-icon></span></a>
                <ul class="uk-nav-sub">
                    <li><a href="#">Sub item</a></li>
                    <li><a href="#">Sub item</a></li>
                </ul>
            </li>
            <li class="uk-parent">
                <a href="#">Extensions <span uk-nav-parent-icon></span></a>
                <ul class="uk-nav-sub">
                    <li><a href="#">Sub item</a></li>
                    <li><a href="#">Sub item</a></li>
                </ul>
            </li>
        </ul>
    </div>

    <div class="uk-card uk-card-default uk-card-body">
        <button class="uk-button uk-button-default uk-margin-small-right" type="button" uk-toggle="target: #offcanvas-usage">HELP</button>
    </div>

    <div id="offcanvas-usage" uk-offcanvas>
        <div class="uk-offcanvas-bar">

            <button class="uk-offcanvas-close" type="button" uk-close></button>

            <h3>Title</h3>

            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>

        </div>
    </div>
</div>
`


// mixins
let commix = await import('/mjs?compo=o-commix');
let mixins = [commix.default.mixin]; // warning: must add .default

let methods = {
    async login() {
        // save admin_api_key to local storage
        localStorage.setItem('api_admin_key', this.center.api_admin_key);
    }
}


// vue js async component
export default {
    template,
    mixins,
    methods,
}