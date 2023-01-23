let panel_default =
`
<section>
    <h2>login</h2>
    <o-form name="login"></o-form>  
</section>
<section>
    <h2>register</h2>
    <o-form name="register"></o-form>  
</section>
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

let commix = await import('/assets/js/o-commix.js');
let mixins = [ commix.default.mixin ]; // warning: must add .default


export default {
    template,
    mixins,
}