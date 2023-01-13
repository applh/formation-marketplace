<!-- add vuejs 3 app -->
<div class="box-vue">
    <div id="app"></div>
    <template id="appTemplate" data-compos="test crud">
        <section>
            <p>{{ api_feedback }}</p>
        </section>

        <section class="uk-section">
            <div class="uk-container">
                <input class="uk-input" type="password" required placeholder="your admin api key" aria-label="your admin api key" v-model="admin_api_key">
                <button class="uk-button uk-button-default" @click.prevent="login">LOGIN</button>
            </div>
        </section>

        <Teleport to=".box-posts">
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
                            {{ api_feedback }}
                        </div>
                    </form>
                </div>
            </section>
        </Teleport>

        <Teleport to=".box-posts">
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
                            <textarea class="uk-textarea" rows="10" name="description" placeholder="description" aria-label="description"></textarea>
                        </div>
                        <div class="uk-margin">
                            <input class="uk-input" type="text" name="image" placeholder="image" aria-label="image" value="https://picsum.photos/id/4/640/640.jpg">
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
                                <a :href="post.image" alt="...">
                                    <img :src="post.image" width="1800" height="1200" alt="">
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
        </Teleport>

        <Teleport to=".box-crud">
            <!-- async components -->
            <o-crud title="post" table="post"></o-crud>
            <o-crud title="user" table="user"></o-crud>
            <o-test></o-test>
            <o-test></o-test>
        </Teleport>
    </template>
</div>