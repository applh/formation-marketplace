<?php

$now = date("Y-m-d H:i:s");

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

    </header>
    <main>
        <h1>Your MarketPlace</h1>
        <p>Current time: <?php echo $now; ?></p>
        <img src="/assets/media/photo-1.jpg" alt="">

        <section>
            <h2>test UIkit</h2>
            <div uk-sortable>
                <div><p>ITEM 1</p></div>
                <div><p>ITEM 2</p></div>
                <div><p>ITEM 3</p></div>
            </div>
        </section>
    </main>
    <footer>
        <p>Your MarketPlace &copy; 2023</p>
    </footer>
</body>
</html>