let panel_default =
`
<div v-if="center.login_ok == false">
    <section>
        <h2>login</h2>
        <o-form name="login"></o-form>  
    </section>
    <section>
        <h2>register</h2>
        <o-form name="register"></o-form>  
    </section>
</div>
<div v-else class="uk-container">
    <h3>Welcome</h3>
    <p>{{ center.api_user_key }}</p>
    <button @click="act_logout">logout</button>
    <h3>Your Posts ({{ posts.length }})</h3>
    <div v-for="post in posts">
        <p>{{ post.title }}</p>
    </div>
    <o-form name="user-post-create"></o-form>  

</div>
`

let template =
`
<div class="panel">
    <div v-if="center.window_w > 2000">
        ${panel_default}
        <h3>Member Dashboard (+2000px)</h3>
        <p>{{ center.window_w + 'x' + center.window_h }}</p>
    </div>
    <div v-else-if="center.window_w > 1500">
        ${panel_default}
        <h3>Member Dashboard (+1500px)</h3>
        <p>{{ center.window_w + 'x' + center.window_h }}</p>
    </div>
    <div v-else-if="center.window_w > 1000">
        ${panel_default}
        <h3>Member Dashboard (+1000px)</h3>
        <p>{{ center.window_w + 'x' + center.window_h }}</p>
    </div>
    <div v-else-if="center.window_w > 500">
        ${panel_default}
        <h3>Member Dashboard (+500px)</h3>
        <p>{{ center.window_w + 'x' + center.window_h }}</p>
    </div>
    <div v-else">
        ${panel_default}
        <h3>Member Dashboard (-500px)</h3>
        <p>{{ center.window_w + 'x' + center.window_h }}</p>
    </div>
</div>
`

let commix = await import('/mjs?compo=o-commix');
let mixins = [ commix.default.mixin ]; // warning: must add .default

let data_compo = {
    posts: []
}

let created = function() {
    // load api_user_key from local storage
    this.center.api_user_key = localStorage.getItem('api_user_key');
    if (this.center.api_user_key) {
        this.center.login_ok = true;
    }
}

let methods = {
    act_logout: function() {
        this.center.api_user_key = null;
        localStorage.removeItem('api_user_key');
        this.center.login_ok = false;
    },
}

export default {
    template,
    mixins,
    data: () => JSON.parse(JSON.stringify(data_compo)),
    methods,
    created,
}