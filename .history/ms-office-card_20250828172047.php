<?php

$categoryModel = new Category();
$subcategoryModel = new Subcategory();
$postModel = new Post();

$categorySlug = "web-development";

$programingCat = $categoryModel->getCategory($categorySlug);
if (!$programingCat) die("Category not found");

$subcategories = $subcategoryModel->getSubcategoriesByCategorySlug($categorySlug);

$filterSubSlug = $_GET['sub'] ?? null;

$limit = 8;
$posts = $filterSubSlug
    ? $postModel->getPostsByCategoryAndSubcategorySlug($categorySlug, $filterSubSlug, $limit)
    : $postModel->getPostsByCategorySlug($categorySlug, $limit);
?>

<section class="px-2">
    <div class="flex justify-between items-center">
        <h1 class="text-xl lg:text-3xl md:text-2xl font-bold text-white <?= $lang === 'kh' ? 'khmer-font-kulen' : '' ?>"><?= $lang === 'en' ? 'Web Development' : 'ឯកសារ អភិវឌ្ឍន៍គេហទំព័រ' ?></h1>
        <a href=""
            class="inline-flex items-center justify-center text-center text-white hover:text-green-400 text-[15px] transition <?= $lang === 'kh' ? 'khmer-font' : '' ?> ">
            <?= $lang === 'en' ? 'See More' : 'មើលទាំងអស់' ?>
            <svg class="w-5 h-5 mt-[1px]" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
        </a>
    </div>
    <!-- Desktop grid -->
    <div class="hidden md:grid md:grid-cols-3 lg:grid-cols-4 gap-2 py-5 mb-4">
        <?php foreach ($posts as $p):
            $sub = $p['subcategory_id'] ? $subcategoryModel->getSubcategory($p['subcategory_id']) : null;
        ?>
            <a href="detail.php?slug=<?= htmlspecialchars($p['slug']) ?>">
                <div class="card bg-gray-800 rounded-lg shadow-md hover:shadow-lg overflow-hidden">
                    <?php if (!empty($p['image'])): ?>
                        <img src="./admin/posts/uploads/<?= htmlspecialchars($p['image']) ?>"
                            alt="<?= htmlspecialchars($p['name']) ?>"
                            class="w-full h-[90px] md:h-[130px] lg:h-[180px] object-cover rounded-none">
                    <?php endif; ?>
                    <div class="card-body px-4 py-2">
                        <h2 class="font-semibold text-lg mb-1"><?= htmlspecialchars($p['name']) ?></h2>

                    </div>
                </div>
            </a>

        <?php endforeach; ?>
    </div>

    <!-- Mobile horizontal scroll -->
    <div class="overflow-x-auto md:hidden py-2">
        <div class="flex space-x-2">
            <?php foreach ($posts as $p): ?>
                <a href="detail.php?slug=<?= htmlspecialchars($p['slug']) ?>" class="flex-shrink-0">
                    <div
                        class="card bg-gray-800 rounded-lg shadow-md hover:shadow-lg overflow-hidden w-[167px] sm:w-[200px]">
                        <?php if (!empty($p['image'])): ?>
                            <img src="./admin/posts/uploads/<?= htmlspecialchars($p['image']) ?>"
                                alt="<?= htmlspecialchars($p['name']) ?>"
                                class="w-full h-[100px] sm:h-[120px]">
                        <?php endif; ?>
                        <div class="card-body px-2 py-1">
                            <h2 class="font-semibold text-sm break-words"><?= htmlspecialchars($p['name']) ?></h2>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>