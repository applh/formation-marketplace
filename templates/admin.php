<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- block search engines -->
    <meta name="robots" content="noindex, nofollow">
    <meta name="description" content="PRIVATE: ADMIN">

    <title>ADMIN</title>

    <link rel="stylesheet" href="/assets/css/uikit.min.css">
    <link rel="stylesheet" href="/assets/css/site.css">
    <style>
        /* admin only css */
    </style>
</head>

<body>
    <header>
        <nav>
            <a href="/">home</a>
            <a href="/admin">admin</a>
        </nav>
    </header>

    <main>
        <h1>ADMIN</h1>
        <p>Current time: <?php echo $now; ?></p>

        <div class="box-crud">
            <!-- Vue will teleport crud here -->
        </div>

        <div class="box-posts">
            <!-- Vue will teleport posts here -->
        </div>
    </main>

    <footer>
        <nav>
            <a href="/">home</a>
            <a href="/credits">credits</a>
            <a href="/#form-contact">contact us</a>
        </nav>
        <p>Your MarketPlace &copy; 2023</p>
    </footer>

    <!-- add vuejs 3 app -->
    <div class="box-vue">
        <div id="app"></div>
        <template id="appTemplate">
            <section>
                <p>{{ api_feedback }}</p>
            </section>

            <Teleport to=".box-posts">
                <section class="uk-section">
                    <div class="uk-container">
                        <h2>CRUD</h2>
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
                                <input class="uk-input" type="password" name="k" required placeholder="your admin api key" aria-label="c" value="">
                            </div>
                            <div class="uk-margin">
                                {{ api_feedback }}
                            </div>
                        </form>
                    </div>
                </section>
            </Teleport>

            <Teleport to=".box-posts">
                <section>
                    <h2>RECENT POSTS</h2>
                    <div class="uk-child-width-1-2@m uk-child-width-1-4@l" uk-grid uk-sortable uk-scrollspy="target: .uk-card-media-top; cls: uk-animation-slide-bottom; delay: 300">
                        <div v-for="(post, index) in posts">
                            <div class="uk-card uk-card-default">
                                <div class="uk-card-media-top" uk-lightbox>
                                    <a :href="post.image" alt="...">
                                        <img :src="post.image" width="1800" height="1200" alt="">
                                    </a>
                                </div>
                                <div class="uk-card-body">
                                    <h3 class="uk-card-title">
                                        <a :href="'/' + post.uri">{{ post.title }}</a>
                                    </h3>
                                    <p>{{ post.description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </Teleport>

        </template>
    </div>

    <script type="module" src="/assets/js/admin.js"></script>

</body>

</html>