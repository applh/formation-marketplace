let template = 
`
<section class="uk-section">
<h2>POSTS (CRUD)</h2>
<div class="uk-container">
    <h3>create/update/delete</h3>
    <form @submit.prevent="send_form($event)">
        <div class="uk-margin">
            <input class="uk-input" type="text" name="path" placeholder="path" aria-label="path" value="post">
        </div>
        <div class="uk-margin">
            <input class="uk-input" type="text" name="template" placeholder="template" aria-label="template" value="post">
        </div>
        <div class="uk-margin">
            <input class="uk-input" type="text" name="title" placeholder="title" aria-label="title">
        </div>
        <div class="uk-margin">
            <textarea class="uk-textarea" rows="10" name="content" placeholder="content" aria-label="content"></textarea>
        </div>
        <div class="uk-margin">
            <input class="uk-input" type="text" name="media" placeholder="media" aria-label="media" value="https://picsum.photos/id/4/640/640.jpg">
        </div>
        <div class="uk-margin">
            <button type="submit" class="uk-button uk-button-default">SEND</button>
        </div>
        <div class="uk-margin">
            <input class="uk-input" type="text" name="c" required placeholder="c" aria-label="c" value="admin">
            <input class="uk-input" type="text" name="m" required placeholder="m" aria-label="m" value="cud_post">
            <input class="uk-input" type="text" name="action" placeholder="action" aria-label="action" value="create">
            <input class="uk-input" type="text" name="id" placeholder="id" aria-label="id">
            <input class="uk-input" type="password" name="k" required placeholder="your admin api key" aria-label="c" v-model="admin_api_key">
        </div>
        <div class="uk-margin">
            {{ api_feedback }}
        </div>
    </form>
</div>
<div class="uk-child-width-1-2@m uk-child-width-1-4@l" uk-grid uk-sortable uk-scrollspy="target: .uk-card-media-top; cls: uk-animation-slide-bottom; delay: 300">
    <div v-for="(post, index) in posts">
        <div class="uk-card uk-card-default">
            <div class="uk-card-media-top" uk-lightbox>
                <a :href="post.media" alt="...">
                    <img :src="post.media" width="1800" height="1200" alt="">
                </a>
            </div>
            <div class="uk-card-body">
                <button class="uk-button uk-button-primary uk-button-small">edit</button>
                <button class="uk-button uk-button-danger uk-button-small">delete</button>
                <h3 class="uk-card-title">
                    <a :href="'/' + post.uri">{{ post.id }} / {{ post.title }}</a>
                </h3>
                <p>{{ post.description }}</p>
            </div>
        </div>
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