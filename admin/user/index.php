<?php
include('../lib/users_lib.php');
include('../lib/permission.php');
$user = new User();
OnlyRolesAdmin();
$users = $user->getUsers();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link href="/dist/output.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/weshare/assets/css/style.css">
</head>

<body>

    <!-- Header -->
    <?php
    include '../include/navbar.php'
    ?>
    <!-- Sidebar -->
    <?php
    include '../include/sidebar.php'
    ?>
    <!-- Main Content -->
    <main class="main-content ml-0 md:ml-64 p-4 mt-[70px]" id="mainContent">

        <!-- Dynamic Content Area -->
        <div id="dynamicContent">
            <!-- Content Sections -->

            <div class="container mx-auto lg:p-10">

                <!-- Header -->
                <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-8">
                    <h2 class="text-3xl font-extrabold text-gray-900 mb-4 md:mb-0">User Management</h2>
                    <a href="create.php"
                        class="bg-indigo-600 text-white font-semibold px-6 py-3 rounded-xl shadow-lg hover:bg-indigo-700 transition duration-300 ease-in-out text-center">
                        + Create New User
                    </a>
                </div>

                <!-- Table -->
                <div class="bg-white rounded-xl shadow-lg overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                            <tr>
                                <th scope="col" class="px-6 py-3">ID</th>
                                <th scope="col" class="px-6 py-3">Name</th>
                                <th scope="col" class="px-6 py-3">Username</th>
                                <th scope="col" class="px-6 py-3">Email</th>

                                <th scope="col" class="px-6 py-3 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($users && count($users) > 0): ?>
                                <?php foreach ($users as $userRow): ?>
                                    <tr class="bg-white border-b hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 font-medium text-gray-900">
                                            <?php echo $userRow['id']; ?>
                                        </td>
                                        <td class="px-6 py-4">
                                            <?php echo htmlspecialchars($userRow['name']); ?>
                                        </td>
                                        <td class="px-6 py-4">
                                            <?php echo htmlspecialchars($userRow['username']); ?>
                                        </td>
                                        <td class="px-6 py-4">
                                            <?php echo htmlspecialchars($userRow['email']); ?>
                                        </td>

                                        <td class="px-6 py-4 flex justify-center space-x-3">
                                            <a href="edit?id=<?php echo $userRow['id']; ?>"
                                                class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                                                Edit
                                            </a>
                                            <a href="delete?id=<?php echo $userRow['id']; ?>"
                                                class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition"
                                                onclick="return confirm('Are you sure you want to delete this user?');">
                                                Delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500 text-lg">
                                        No users found.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </main>


    <script src="../assets/js/admin_script.js"></script>
</body>

</html>