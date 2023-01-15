<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/assets/media/photo-1.jpg" type="image/jpeg">

    <meta name="description" content="Your MarketPlace with PHP+SQL">
    <title>Your MarketPlace with PHP+SQL</title>

    <link rel="stylesheet" href="/assets/css/uikit.min.css">
    <link rel="stylesheet" href="/assets/css/site.css">

</head>

<body>
    <header>
        <nav>
            <a href="/">home</a>
            <a href="/#form-contact">contact us</a>
        </nav>
    </header>

    <main>
        <h1>Your MarketPlace</h1>
        <p>Current time: <?php echo $now; ?></p>
        <img src="/assets/media/photo-1.jpg" alt="" class="banner">

        <section>
            <h2>RECENT POSTS (PHP loop) 🔥</h2>
            <div class="uk-child-width-1-2@m uk-child-width-1-4@l" uk-grid uk-sortable uk-scrollspy="target: .uk-card-media-top; cls: uk-animation-slide-bottom; delay: 300">
                <?php foreach (model::read("post", "post", "path") as $key => $post) : ?>
                    <?php extract($post) ?>
                    <div>
                        <div class="uk-card uk-card-default">
                            <div class="uk-card-media-top" uk-lightbox>
                                <a href="<?php echo $media ?>" alt="...">
                                    <img src="<?php echo $media ?>" width="1800" height="1200" alt="">
                                </a>
                            </div>
                            <div class="uk-card-body">
                                <h3 class="uk-card-title">
                                    <a href="/<?php echo $uri ?>"><?php echo $title ?></a>
                                </h3>
                                <p><?php echo $content ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <div class="box-posts">
            <!-- Vue will teleport posts here -->
        </div>
    </main>

    <footer>

        <section class="uk-section" id="form-contact">
            <div class="uk-container box-form-contact">
            </div>
        </section>

        <nav>
            <a href="/">home</a>
            <a href="/credits">credits</a>
            <a href="/#form-contact">contact us</a>
        </nav>
        <p>Your MarketPlace &copy; 2023</p>
        <nav>
            <a href="/admin">admin</a>
        </nav>
    </footer>

    <!-- add vuejs 3 app -->
    <div class="box-vue">
        <div id="app"></div>
        <template id="appTemplate">
            <section>
                <p>{{ api_feedback }}</p>
            </section>

            <Teleport to=".box-posts">
                <section>
                    <h2>RECENT POSTS (list by Vue / loop + teleport) 🔥</h2>
                    <div class="uk-child-width-1-2@m uk-child-width-1-4@l" uk-grid uk-sortable uk-scrollspy="target: .uk-card-media-top; cls: uk-animation-slide-bottom; delay: 300">
                        <div v-for="(post, index) in posts">
                            <div class="uk-card uk-card-default">
                                <div class="uk-card-media-top" uk-lightbox>
                                    <a :href="post.image" alt="...">
                                        <img :src="post.media" width="1800" height="1200" alt="">
                                    </a>
                                </div>
                                <div class="uk-card-body">
                                    <h3 class="uk-card-title">
                                        <a :href="'/' + post.uri">{{ post.title }}</a>
                                    </h3>
                                    <p>{{ post.content }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </Teleport>

            <Teleport to=".box-form-contact">
                <p>contact us</p>
                <form @submit.prevent="send_form($event)">
                    <div class="uk-margin">
                        <input class="uk-input" type="text" name="name" required placeholder="Your Name" aria-label="Your Name">
                    </div>
                    <div class="uk-margin">
                        <input class="uk-input" type="email" name="email" required placeholder="Your Email" aria-label="Your Email">
                    </div>
                    <div class="uk-margin">
                        <textarea class="uk-textarea" rows="10" name="message" required placeholder="Your Message" aria-label="Your Message"></textarea>
                    </div>
                    <div class="uk-margin">
                        <button type="submit" class="uk-button uk-button-default">SEND YOUR MESSAGE</button>
                    </div>
                    <input type="hidden" name="m" value="contact">
                    <div class="uk-margin">
                        {{ api_feedback }}                
                    </div>
                </form>
            </Teleport>

        </template>

    </div>
    <script type="module" src="/assets/js/site.js"></script>

</body>

</html>