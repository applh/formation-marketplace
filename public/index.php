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
    <link rel="stylesheet" href="/assets/site.css">
    <script type="module" src="/assets/site.js"></script>
</head>
<body>
    <header>

    </header>
    <main>
        <h1>Your MarketPlace</h1>
        <p>Current time: <?php echo $now; ?></p>
        <img src="/assets/photo-1.jpg" alt="">
    </main>
    <footer>
        <p>Your MarketPlace &copy; 2023</p>
    </footer>
</body>
</html>