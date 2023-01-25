let template = 
`
<section class="uk-section">
<div class="uk-container">
    <h2>API</h2>
    <form @submit.prevent="send_form($event)">
        <div class="uk-margin">
            <input class="uk-input" type="text" name="path" placeholder="Your Path" aria-label="Your Path">
        </div>
        <div class="uk-margin">
            <textarea class="uk-textarea" rows="10" name="code" placeholder="Your code" aria-label="Your Code"></textarea>
        </div>
        <div class="uk-margin">
            <button type="submit" class="uk-button uk-button-default">SEND YOUR REQUEST</button>
        </div>
        <div class="uk-margin">
            <input class="uk-input" type="text" name="c" required placeholder="c" aria-label="c" value="admin">
            <input class="uk-input" type="text" name="m" required placeholder="m" aria-label="m" value="test">
            <input class="uk-input" type="password" name="k" required placeholder="your admin api key" aria-label="c" v-model="admin_api_key">
        </div>
        <div class="uk-margin">
            {{ center.api_feedback }}
        </div>
    </form>
</div>
</section>
`


// mixins
let commix = await import('/mjs?compo=o-commix');
let mixins = [ commix.default.mixin ]; // warning: must add .default


// vue js async component
export default {
    template,
    mixins,
}