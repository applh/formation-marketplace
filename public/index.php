<?php
// load framework
require __DIR__ . "/../framework.php";

$now = date("Y-m-d H:i:s");
$uri = $_SERVER["REQUEST_URI"] ?? "";


// note: 
// with PHP local server, url http://localhost:8000 will give $uri = "/"
// with PHP local server, url http://localhost:8000/ will give $uri = "/"
// and http://localhost:8000/index.php will give $uri = "/index.php"

$myuri = trim($uri, "/");
$myuri = $myuri ?: "index.php";

// parse the uri
extract(pathinfo($myuri));
$filename ??= "";

// debug to the header
header("X-URI: $uri,$filename");

if ($filename != "index") {
    $post = $posts[$filename] ?? [];
    extract($post);    
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Your MarketPlace with PHP+SQL">
    <title>Your MarketPlace with PHP+SQL</title>

    <link rel="stylesheet" href="/assets/css/uikit.min.css">
    <link rel="stylesheet" href="/assets/css/site.css">

    <script src="/assets/js/uikit.min.js"></script>
    <script src="/assets/js/uikit-icons.min.js"></script>
    <script type="module" src="/assets/js/site.js"></script>
</head>

<body>
    <header>
        <nav>
            <a href="/">home</a>
        </nav>
    </header>

<?php if ($filename === "index") : ?> 
           
    <main>
        <h1>Your MarketPlace</h1>
        <p>Current time: <?php echo $now; ?></p>
        <img src="/assets/media/photo-1.jpg" alt="" class="banner">

        <section>
            <h2>RECENT POSTS (PHP loop) 🔥</h2>
            <div class="uk-child-width-1-2@m uk-child-width-1-4@l" uk-grid uk-sortable uk-scrollspy="target: .uk-card-media-top; cls: uk-animation-slide-bottom; delay: 300">
                <?php foreach ($posts as $key => $post) : ?>
                    <?php extract($post) ?>
                    <div>
                        <div class="uk-card uk-card-default">
                            <div class="uk-card-media-top" uk-lightbox>
                                <a href="<?php echo $image ?>" alt="...">
                                    <img src="<?php echo $image ?>" width="1800" height="1200" alt="">
                                </a>
                            </div>
                            <div class="uk-card-body">
                                <h3 class="uk-card-title">
                                    <a href="/<?php echo $uri ?>"><?php echo $title ?></a>
                                </h3>
                                <p><?php echo $description ?></p>
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
        <p>Your MarketPlace &copy; 2023</p>
    </footer>

    <!-- add vuejs 3 app -->
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
    <script type="module">
        // import vue js 3
        import * as Vue from '/assets/js/vue.esm-browser.prod.min.js';
        // create vue app

        // separate data for better readability
        const appData = {
            posts: [],
            api_feedback: '...',
            message: 'Hello Vue 3!'
        };

        const app = Vue.createApp({
            template: '#appTemplate',
            data: () => appData,
            async created() {
                // fetch data from api
                let response = await fetch('/api.php');
                let json = await response.json();
                this.api_feedback = json.feedback ?? 'xxx';
                this.posts = json.posts ?? [];
            }
        });

        // mount vue app
        app.mount('#app');
    </script>

<?php else: ?>

    <main>
        <h1><?php echo $title ?></h1>
        <section class="uk-section">
            <div class="uk-container">

                <h2><?php echo $title ?></h2>
                <div class="" uk-grid uk-sortable uk-scrollspy="target: .uk-card-media-top; cls: uk-animation-slide-bottom; delay: 300">
                    <div>
                        <div class="uk-card uk-card-default">
                            <div class="uk-card-media-top" uk-lightbox>
                                <a href="<?php echo $image ?>" alt="...">
                                    <img src="<?php echo $image ?>" width="1800" height="1200" alt="">
                                </a>
                            </div>
                            <div class="uk-card-body">
                                <h3 class="uk-card-title">
                                    <a href="/<?php echo $uri ?>"><?php echo $title ?></a>
                                </h3>
                                <p><?php echo $description ?></p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </main>

<?php endif ?>

</body>

</html>