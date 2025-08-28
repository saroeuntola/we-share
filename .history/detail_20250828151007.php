<?php
include './admin/lib/db.php';
include './admin/lib/post_lib.php';
include './admin/lib/category_lib.php';
include './admin/lib/subcategory_lib.php';
$lang = isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'kh']) ? $_GET['lang'] : 'en';
$postModel = new Post($lang);
$categoryModel = new Category($lang);
$subcategoryModel = new Subcategory($lang);

// Get slug from URL
$slug = $_GET['slug'] ?? null;
if (!$slug) {
    die("Post not found");
}

// Get post by slug
$post = $postModel->getPostBySlug($slug, $lang);
if (!$post) {
    die("Post not found");
}

$category = $categoryModel->getCategory($post['category_id']);
$subcategory = $post['subcategory_id'] ? $subcategoryModel->getSubcategory($post['subcategory_id']) : null;

$relatedPosts = $postModel->getPostsByCategory($post['category_id']);
$relatedPosts = array_filter($relatedPosts, fn($p) => $p['id'] != $post['id']);
$relatedPosts = array_slice($relatedPosts, 0, 8);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($post['name']) ?> - Detail</title>
    <link rel="stylesheet" href="./assets/css/output.css">
    <link rel="stylesheet" href="./assets/css/custom.css">
</head>

<body class=" bg-gray-600">
    <header class="fixed z-10 w-full" id="header">
        <?php
        include 'head-bar.php'
        ?>
    </header>
    <main class="max-w-7xl mx-auto p-2 mt-[80px]">
        <div class="overflow-hidden mb-10">
            <h1 class="lg:text-3xl text-lg text-white font-bold mb-4 <?= $lang === 'kh' ? 'khmer-font-kulen' : '' ?>">
                <?= htmlspecialchars($post['name']) ?>
            </h1>

            <div class="bg-gray-800 text-white p-3">
                <!-- Image floated left -->
                <?php if (!empty($post['image'])): ?>
                    <img src="./admin/posts/uploads/<?= htmlspecialchars($post['image']) ?>"
                        alt="<?= htmlspecialchars($post['name']) ?>"
                        class="float-left w-full lg:w-1/2 h-[175px] lg:h-[350px] object-cover me-4 mb-4">
                <?php endif; ?>

                <!-- Text content -->
                <p class="mb-3">
                    <span class="font-semibold <?= $lang === 'kh' ? 'khmer-font' : '' ?>"><?= $lang === 'en' ? 'Category:' : 'ប្រភេទៈ' ?></span> <?= $category ? htmlspecialchars($category['name']) : '-' ?>
                    <span class="font-semibold <?= $lang === 'kh' ? 'khmer-font' : '' ?>">,</span> <?= $subcategory ? htmlspecialchars($subcategory['name']) : '-' ?><br>
                    <span class="font-semibold <?= $lang === 'kh' ? 'khmer-font' : '' ?>"><?= $lang === 'en' ? 'Post by:' : 'បង្ហោះដោយៈ' ?></span> <?= htmlspecialchars($post['added_by']) ?><br>
                    <span class="font-semibold <?= $lang === 'kh' ? 'khmer-font' : '' ?>"><?= $lang === 'en' ? 'Post Date:' : 'កាលបរិច្ឆេទៈ' ?></span> <?= htmlspecialchars($post['created_at']) ?>
                </p>

                <div class="text-gray-200">
                    <?= $post['description'] ?>
                </div>
                <?php
                if ($lang === 'en') {
                    echo '<p class="text-red-500 rounded-lg text-sm md:text-base mt-4​ ">
        <strong>Note:</strong> Documents or software hosted on <span class="font-semibold">weshare.com</span> are not owned by this site. If you are the copyright owner and wish to request removal, please <a href="/contact" class="underline text-blue-600 hover:text-blue-800">contact us</a> and we will remove it promptly.
    </p>';
                } else {
                    echo '<p class="text-red-500 rounded-lg text-sm md:text-base mt-4 ">
        <strong>កំណត់ចំណាំ៖</strong> ឯកសារ ឬកម្មវិធីដែលផ្ទុកនៅលើ <span class="font-semibold">WeShare.com</span> មិនមែនជាកម្មសិទ្ធិរបស់គេហទំព័រនេះឡើយ។ ប្រសិនបើអ្នកជាម្ចាស់កម្មសិទ្ធិ និងចង់ស្នើសុំយកចេញ សូម <a href="/contact" class="underline text-blue-600 hover:text-blue-800">ទំនាក់ទំនងមកពួកយើង</a> ហើយពួកយើងនឹងលុបវាឲ្យភ្លាមៗ។
    </p>';
                }
                ?>
                <!-- Clear float at the end -->
                <div class="clear-both"></div>
            </div>
        </div>

        <!-- Related Posts -->
        <?php if (!empty($relatedPosts)): ?>
            <div class="">
                <h2 class="text-2xl font-bold mb-4 text-white">Related Posts</h2>
                <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2">
                    <?php foreach ($relatedPosts as $p): ?>
                        <a href="detail.php?slug=<?= htmlspecialchars($p['slug']) ?>&lang=<?= $lang ?>">
                            <div class="card bg-gray-800 rounded-lg shadow-md hover:shadow-lg overflow-hidden">
                                <?php if (!empty($p['image'])): ?>
                                    <img src="./admin/posts/uploads/<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>" class="w-full h-[90px] md:h-[130px] lg:h-[160px] object-cover rounded-none">
                                <?php endif; ?>
                                <div class="card-body p-2">
                                    <h2 class="font-semibold text-sm lg:text-lg md:text-lg mb-1"><?= htmlspecialchars($p['name']) ?></h2>
                                    <p class="text-gray-400 text-xs">
                                        Date: <?= htmlspecialchars($p['created_at']) ?>
                                    </p>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </main>

</body>

</html>