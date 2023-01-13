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
        /* limit height to 5 rem */
        td > div {
            max-height: 5rem;
            overflow-y: auto;
        }
        td > div:hover {
            max-height: 10rem;
            overflow-y: auto;
        }
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

<?php require __DIR__ . "/vue/admin-app.php"; ?>  
<script type="module">
<?php require __DIR__ . "/vue/admin.js"; ?>  
</script>

</body>

</html>