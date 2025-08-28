<?php
include '../lib/category_lib.php';
include '../lib/subcategory_lib.php';
include('../lib/permission.php');
onlyPosterAndAdmincanAccess();
$categoryModel = new Category();
$subcategoryModel = new Subcategory();

$categories = $categoryModel->getCategories();
$subcategories = $subcategoryModel->getAllSubcategory();
$added_by = $_SESSION['username'] ?? ($_SESSION['user']['username'] ?? 'Guest');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_subcategory'])) {
    $subcategory_id = !empty($_POST['subcategory_id']) ? intval($_POST['subcategory_id']) : null;
    $category_id = !empty($_POST['category_id']) ? intval($_POST['category_id']) : null;
    $name_en = trim($_POST['name_en'] ?? '');
    $name_kh = trim($_POST['name_kh'] ?? '');

    // Validate category ID
    if ($category_id === null || !$categoryModel->getCategory($category_id)) {
        die("Invalid category ID.");
    }

    if ($subcategory_id) {
        // Update: subcategory ID exists
        $subcategoryModel->updateSubcategory(
            $subcategory_id,
            $name_en,
            $name_kh,
            $category_id,
            $added_by
        );
    } else {
        // Create new subcategory
        $subcategoryModel->createSubcategory(
            $category_id,
            $name_en,
            $name_kh,
            $added_by
        );
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subcategory Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>

    <!-- Navbar -->
    <?php include '../include/navbar.php' ?>

    <div class="f">

        <!-- Sidebar -->
        <?php include '../include/sidebar.php' ?>

        <!-- Main Content -->
        <main class="ml-0 md:ml-64 p-4 mt-[70px]">
            <div class=" justify-between items-center mb-6">
                <h1 class="text-2xl font-bold mb-4">Subcategory Management</h1>
                <button onclick="openModal()"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md shadow transition">+ Add Sub Category</button>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto bg-white shadow rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Sub Category (EN)</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Sub Category (KH)</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Added By</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Created At</th>
                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($subcategories as $sub):
                            $cat = $categoryModel->getCategory($sub['category_id']);
                        ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2"><?= $sub['id'] ?></td>
                                <td class="px-4 py-2"><?= $cat ? htmlspecialchars($cat['name']) : '-' ?></td>
                                <td class="px-4 py-2"><?= htmlspecialchars($sub['name']) ?></td>
                                <td class="px-4 py-2"><?= htmlspecialchars($sub['name_kh']) ?></td>
                                <td class="px-4 py-2"><?= htmlspecialchars($sub['added_by']) ?></td>
                                <td class="px-4 py-2"><?= htmlspecialchars($sub['created_at']) ?></td>
                                <td class="px-4 py-2 flex justify-center gap-2">
                                    <button class="bg-yellow-400 hover:bg-yellow-500 text-white px-2 py-1 rounded-md text-sm"
                                        onclick='openModal(<?= json_encode($sub) ?>)'>Edit</button>
                                    <?php if (isset($_SESSION['role_id']) && $_SESSION['role_id'] == 1): ?>
                                        <a href="delete?slug=<?= urlencode($sub['slug']) ?>"
                                            class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded-md text-sm"
                                            onclick="return confirm('Are you sure?')">Delete</a>
                                    <?php else: ?>
                                        <a href="#" class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded-md text-sm"
                                            onclick="return noPermission()">Delete</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Modal Form -->
            <div id="subcategoryModal"
                class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden overflow-y-auto">
                <div class="relative mt-12 mb-12 mx-auto max-w-2xl bg-white rounded-lg shadow-lg p-6 w-full">
                    <span class="absolute top-2 right-3 text-gray-500 cursor-pointer text-2xl font-bold"
                        onclick="closeModal()">&times;</span>
                    <h2 id="modalTitle" class="text-xl font-bold mb-4">Create Subcategory</h2>
                    <form method="POST" class="space-y-4">
                        <input type="hidden" name="subcategory_id" id="subcategory_id">

                        <div>
                            <label class="block font-medium mb-1">Category</label>
                            <select name="category_id" id="category_id"
                                class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                                <option value="">-- Select Category --</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Subcategory Name (English)</label>
                            <input type="text" name="name_en" id="name_en"
                                class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Subcategory Name (Khmer)</label>
                            <input type="text" name="name_kh" id="name_kh"
                                class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div class="flex justify-end">
                            <input type="submit"
                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md shadow cursor-pointer"
                                name="submit_subcategory" value="Save Subcategory">
                        </div>
                    </form>
                </div>
            </div>

        </main>
    </div>

    <script>
        /* Keep all JS intact */
        function noPermission() {
            alert("You do not have permission to perform this action!");
            return false;
        }

        function openModal(sub = null) {
            document.getElementById('subcategoryModal').style.display = 'block';
            if (sub) {
                document.getElementById('modalTitle').innerText = 'Edit Subcategory';
                document.getElementById('subcategory_id').value = sub.id;
                document.getElementById('category_id').value = sub.category_id;
                document.getElementById('name_en').value = sub.name;
                document.getElementById('name_kh').value = sub.name_kh;
            } else {
                document.getElementById('modalTitle').innerText = 'Create Subcategory';
                document.getElementById('subcategory_id').value = '';
                document.getElementById('category_id').value = '';
                document.getElementById('name_en').value = '';
                document.getElementById('name_kh').value = '';
            }
        }

        function closeModal() {
            document.getElementById('subcategoryModal').style.display = 'none';
        }

        window.onclick = function(event) {
            const modal = document.getElementById('subcategoryModal');
            if (event.target == modal) modal.style.display = 'none';
        }
    </script>

</body>

</html>