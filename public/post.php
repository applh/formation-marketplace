<?php
// load framework
require __DIR__ . "/../framework.php";

// CONTENT
// get he data
$now = date("Y-m-d H:i:s");

$index = intval($_GET["index"] ?? 0);

$post = $posts[$index] ?? [];
extract($post);

// TEMPLATE
// fill the template with content
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
                                    <a href="/post.php?index=<?php echo $index ?>"><?php echo $title ?></a>
                                </h3>
                                <p><?php echo $description ?></p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </main>
    <footer>
        <p>Your MarketPlace &copy; 2023</p>
    </footer>


</body>

</html>