<?php
include './admin/lib/db.php';
include './admin/lib/post_lib.php';
include './admin/lib/category_lib.php';
include './admin/lib/subcategory_lib.php';
$lang = isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'kh']) ? $_GET['lang'] : 'en';
$categoryModel = new Category($lang);
$subcategoryModel = new Subcategory($lang);
$postModel = new Post($lang);

$categorySlug = "programming";

// Get category by slug
$programingCat = $categoryModel->getCategory($categorySlug);
if (!$programingCat) {
    die("Category not found");
}

// Get subcategories by category slug
$subcategories = $subcategoryModel->getSubcategoriesByCategorySlug($categorySlug);

$filterSubSlug = $_GET['sub'] ?? null;

// Fetch posts
if ($filterSubSlug) {
    $posts = $postModel->getPostsByCategoryAndSubcategorySlug($categorySlug, $filterSubSlug);
} else {
    $posts = $postModel->getPostsByCategorySlug($categorySlug);
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Programming</title>
    <link rel="stylesheet" href="./assets/css/output.css">
    <link rel="stylesheet" href="./assets/css/custom.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <style>
        .card {
            margin-bottom: 3px;
        }
    </style>
</head>

<body class="bg-gray-600">
    <?php include 'loading.php' ?>
    <header class="fixed z-10 w-full" id="header">
        <?php
        include 'head-bar.php'
        ?>
    </header>

    <main class="max-w-7xl m-auto p-2 mt-[80px]">
        <a href="index?lang=<?= $lang ?>"
            class="inline-flex justify-end items-center text-white hover:text-green-400 transition mb-4">
            <!-- Arrow Icon -->
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            <?= $lang === 'en' ? 'Back Home' : 'ត្រឡប់ទៅទំព័រដើម' ?>
        </a>

        <div class=" justify-between items-center gap-4 mb-5">
            <h2 class="lg:text-2xl text-[20px] font-bold text-white <?= $lang === 'kh' ? 'khmer-font-kulen' : '' ?>"><?= $lang === 'en' ? 'Programming' : 'ឯកសារ រសរសេរកម្មវិធី' ?></h2>

            <div id="subcategoryDropdown" class="flex flex-wrap gap-2 mt-4">
                <a href="?sub="
                    class="px-4 py-2 rounded-lg text-sm font-medium 
              <?php echo empty($filterSubSlug)
                    ? 'bg-green-600 text-white'
                    : ($lang === 'en' ? 'Back Home' : 'ត្រឡប់ទៅទំព័រដើម') ?>">
                   
                </a>

                <!-- Loop subcategories -->
                <?php foreach ($subcategories as $sub): ?>
                    <a href="?sub=<?php echo htmlspecialchars($sub['slug']); ?>"
                        class="px-4 py-2 rounded-lg text-sm font-medium 
                  <?php echo ($filterSubSlug === $sub['slug'])
                        ? 'bg-green-600 text-white'
                        : 'bg-gray-200 text-gray-700 hover:bg-gray-300'; ?>">
                        <?php echo htmlspecialchars($sub['name']); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>


        <div class="posts-container">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2">
                <?php foreach ($posts as $p):

                ?>
                    <div class="card bg-gray-800 rounded-lg shadow-md">
                        <a href="detail?slug=<?= htmlspecialchars($p['slug']) ?>&lang=<?= $lang ?>">
                            <?php if (!empty($p['image'])): ?>
                                <img src="./admin/posts/uploads/<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>" class="w-full h-[115px] md:h-[130px] lg:h-[180px]">
                            <?php endif; ?>
                            <h2 class="font-semibold lg:text-lg text-[14px] p-2 text-white"><?= htmlspecialchars($p['name']) ?></h2>
                        </a>

                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    </main>
    <section class="">
        <?php include 'footer.php' ?>
    </section>
</body>

</html>