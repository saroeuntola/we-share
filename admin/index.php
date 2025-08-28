<?php
include('../admin/lib/users_lib.php');
include('../admin/lib/permission.php');
onlyPosterAndAdmincanAccess();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link rel="stylesheet" href="/weshare/assets/css/style.css">
</head>

<body class="">
    <!-- header -->
    <?php
    include './include/navbar.php'
    ?>

    <!-- Sidebar -->
    <?php
    include './include/sidebar.php'
    ?>

    <!-- main content -->
    <main>
        <div class="table-container mt-8">
            <p>hi</p>
        </div>
    </main>



</body>

</html>