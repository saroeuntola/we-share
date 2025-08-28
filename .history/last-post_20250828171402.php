<?php
include './admin/lib/db.php';
include './admin/lib/post_lib.php';
include './admin/lib/category_lib.php';
include './admin/lib/subcategory_lib.php';

$postModel = new Post();
$categoryModel = new Category();
$subcategoryModel = new Subcategory();

// --- FILTERS ---
$categorySlug = $_GET['category'] ?? null;
$subcategorySlug = $_GET['subcategory'] ?? null;

$categoryId = null;
$subcategoryId = null;
$subcategories = [];

// Get category
if ($categorySlug) {
    $cat = $categoryModel->getCategory($categorySlug);
    $categoryId = $cat['id'] ?? null;

    if ($categoryId) {
        $subcategories = $subcategoryModel->getSubcategoriesByCategory($categoryId);
    }
}

// Get subcategory
if ($subcategorySlug && $categoryId) {
    $sub = $subcategoryModel->getSubcategory($subcategorySlug);
    $subcategoryId = $sub['id'] ?? null;
}

// --- GET POSTS ---
$allPosts = array_filter($postModel->getPosts(), function ($p) use ($categoryId, $subcategoryId) {
    if ($categoryId && $p['category_id'] != $categoryId) return false;
    if ($subcategoryId && $p['subcategory_id'] != $subcategoryId) return false;
    return true;
});

// Sort descending
usort($allPosts, fn($a, $b) => strtotime($b['created_at']) - strtotime($a['created_at']));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lastest Posts</title>
    <link rel="stylesheet" href="./assets/css/output.css">
    <link rel="stylesheet" href="./assets/css/custom.css">
</head>

<body class="bg-gray-600">
    <header class="fixed z-10 w-full" id="header">
        <?php
        include 'head-bar.php'
        ?>
    </header>
    <main class="max-w-7xl m-auto p-2 mt-[80px]">
        <div class="">
            <a href="index.php"
                class="inline-flex justify-end items-center text-white hover:text-green-400 transition mb-6">
                <!-- Arrow Icon -->
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Back Home
            </a>
            <h1 class="lg:text-3xl text-2xl font-bold mb-6 text-white">Lastest Posts</h1>

            <!-- CATEGORY FILTER -->
            <div class="relative inline-block mb-4">
                <button id="dropdownButton" type="button"
                    class="text-white bg-blue-700 hover:bg-green-600 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center"
                    onclick="toggleDropdown('categoryDropdown')">
                    <?= $categorySlug
                        ? htmlspecialchars($categoryModel->getCategory($categorySlug)['name'])
                        : 'All Categories' ?>
                    <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                    </svg>
                </button>

                <!-- Dropdown menu -->
                <div id="categoryDropdown" class="absolute z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 mt-2">
                    <ul class="py-2 text-sm text-gray-700">
                        <li>
                            <a href="<?= $_SERVER['PHP_SELF'] ?>" class="block px-4 py-2 hover:bg-gray-100">
                                All Categories
                            </a>
                        </li>
                        <?php foreach ($categoryModel->getCategories() as $catOption): ?>
                            <li>
                                <a href="?category=<?= htmlspecialchars($catOption['slug']) ?>"
                                    class="block px-4 py-2 hover:bg-gray-100">
                                    <?= htmlspecialchars($catOption['name']) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </main>
    <!-- SUBCATEGORY FILTER -->
    <?php if (!empty($subcategories)): ?>
        <div class="mb-4 flex flex-wrap gap-2 max-w-7xl m-auto px-2">
            <a href="?category=<?= htmlspecialchars($categorySlug) ?>"
                class="px-3 py-1 rounded <?= !$subcategorySlug ? 'bg-green-700 text-white' : 'bg-gray-300 text-gray-800' ?>">
                All Subcategories
            </a>
            <?php foreach ($subcategories as $sub): ?>
                <a href="?category=<?= htmlspecialchars($categorySlug) ?>&subcategory=<?= htmlspecialchars($sub['slug']) ?>"
                    class="px-3 py-1 rounded <?= ($subcategorySlug === $sub['slug']) ? 'bg-green-700 text-white' : 'bg-gray-300 text-gray-800' ?>">
                    <?= htmlspecialchars($sub['name']) ?>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- POSTS GRID -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2 max-w-7xl m-auto px-2">
        <?php foreach ($allPosts as $p):
            $cat = $categoryModel->getCategory($p['category_id']);
            $sub = $p['subcategory_id'] ? $subcategoryModel->getSubcategory($p['subcategory_id']) : null;
        ?>
            <div class="bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <a href="detail.php?slug=<?= htmlspecialchars($p['slug']) ?>&lang=<?= $lang ?>" class=" cursor-pointer">
                    <?php if (!empty($p['image'])): ?>
                        <img src=" ./admin/posts/uploads/<?= htmlspecialchars($p['image']) ?>"
                    alt="<?= htmlspecialchars($p['name']) ?>" class="w-full h-[115px] md:h-[130px] lg:h-[180px] rounded-none">
                <?php endif; ?>
                <div class="p-2 text-white">
                    <h2 class="font-semibold lg:text-lg text-[14px]"><?= htmlspecialchars($p['name']) ?></h2>
                    <p class="text-gray-300 text-sm">
                        <?= htmlspecialchars($cat['name'] ?? '') ?>
                        <?= $sub ? ' / ' . htmlspecialchars($sub['name']) : '' ?>
                    </p>
                </div>
                </a>

            </div>
        <?php endforeach; ?>
    </div>


    <script>
        function toggleDropdown(id) {
            const dropdown = document.getElementById(id);
            dropdown.classList.toggle('hidden');
        }

        // Optional: close dropdown when clicking outside
        window.addEventListener('click', function(e) {
            const dropdown = document.getElementById('categoryDropdown');
            const button = document.getElementById('dropdownButton');
            if (!dropdown.contains(e.target) && !button.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });
    </script>
</body>

</html>