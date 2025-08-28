<!DOCTYPE html>
<html lang="en">

<body class="bg-gray-600">
    <?php include 'loading.php' ?>
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

        <section class="mt-6">
            <?php
            include 'ms-office-card.php'
            ?>
        </section>
    </main>


</body>

</html>