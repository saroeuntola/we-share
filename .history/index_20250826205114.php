<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Latest Posts</title>
    <link rel="stylesheet" href="./assets/css/output.css">
    <link rel="stylesheet" href="./assets/css/custom.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="bg-gray-600">
    <header class="fixed z-10 w-full" id="header">
        <?php
        include 'head-bar.php'
        ?>
    </header>

    <main class="max-w-7xl m-auto mt-[95px]">
        <section class="mb-6">
            <?php
            include 'key-frame.php'
            ?>
        </section>

        <section>
            <?php
            include 'last-post-card.php'
            ?>

        </section>

        <section class="mt-6">
            <?php
            include 'programing-card.php'
            ?>
        </section>

        <section class="mt-6">
            <?php
            include 'web-dev-card.php'
            ?>
        </section>
    </main>


</body>

</html>