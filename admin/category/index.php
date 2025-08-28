<?php
include '../lib/db.php';
include '../lib/category_lib.php';

$categoryModel = new Category();
$categories = $categoryModel->getCategories();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_category'])) {
    $category_id = $_POST['category_id'] ?? null;
    $name_en = $_POST['name_en'] ?? '';
    $name_kh = $_POST['name_kh'] ?? '';

    if ($category_id) {
        $categoryModel->updateCategory($category_id, $name_en, $name_kh);
    } else {
        $categoryModel->createCategory($name_en, $name_kh);
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
    <title>Category Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans">

    <?php include '../include/navbar.php' ?>
    <?php include '../include/sidebar.php' ?>

    <main class="ml-0 md:ml-64 p-4 mt-10">
        <div class="justify-between items-center mt-6 mb-4">
            <h1 class="text-2xl mb-4 font-bold text-gray-800">Category Management</h1>
            <button onclick="openModal()"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md shadow">
                + Add Category
            </button>
        </div>

        <div class="overflow-x-auto bg-white rounded-lg shadow-md">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name (EN)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name (KH)</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($categories as $cat): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?= $cat['id'] ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?= htmlspecialchars($cat['name']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?= htmlspecialchars($cat['name_kh']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap flex justify-center gap-2">
                                <button onclick='openModal(<?= json_encode($cat) ?>)'
                                    class="px-3 py-1 bg-yellow-400 text-white rounded hover:bg-yellow-500">Edit</button>
                                <?php if (isset($_SESSION['role_id']) && $_SESSION['role_id'] == 1): ?>
                                    <a href="delete?slug=<?= urlencode($cat['slug']) ?>"
                                        onclick="return confirm('Are you sure?')"
                                        class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">Delete</a>
                                <?php else: ?>
                                    <button onclick="noPermission()" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">Delete</button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Modal -->
        <div id="categoryModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 id="modalTitle" class="text-xl font-bold text-gray-800">Create Category</h2>
                    <button class="text-gray-500 hover:text-gray-800" onclick="closeModal()">&times;</button>
                </div>
                <form method="POST" class="space-y-4">
                    <input type="hidden" name="category_id" id="category_id">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Category Name (English)</label>
                        <input type="text" name="name_en" id="name_en"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Category Name (Khmer)</label>
                        <input type="text" name="name_kh" id="name_kh"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button" onclick="closeModal()"
                            class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                        <input type="submit" name="submit_category" value="Save"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 cursor-pointer">
                    </div>
                </form>
            </div>
        </div>

    </main>

    <script>
        function openModal(cat = null) {
            document.getElementById('categoryModal').classList.remove('hidden');
            if (cat) {
                document.getElementById('modalTitle').innerText = 'Edit Category';
                document.getElementById('category_id').value = cat.id;
                document.getElementById('name_en').value = cat.name;
                document.getElementById('name_kh').value = cat.name_kh;
            } else {
                document.getElementById('modalTitle').innerText = 'Create Category';
                document.getElementById('category_id').value = '';
                document.getElementById('name_en').value = '';
                document.getElementById('name_kh').value = '';
            }
        }

        function closeModal() {
            document.getElementById('categoryModal').classList.add('hidden');
        }

        function noPermission() {
            alert("You do not have permission to perform this action!");
            return false;
        }

        window.onclick = function(event) {
            const modal = document.getElementById('categoryModal');
            if (event.target === modal) modal.classList.add('hidden');
        }
    </script>
</body>

</html>