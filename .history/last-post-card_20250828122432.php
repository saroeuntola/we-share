<?php
include './admin/lib/db.php';
include './admin/lib/post_lib.php';
include './admin/lib/category_lib.php';
include './admin/lib/subcategory_lib.php';
$lang = isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'kh']) ? $_GET['lang'] : 'en';

$postModel = new Post($lang);
$categoryModel = new Category($lang);
$subcategoryModel = new Subcategory($lang);

// Get latest 10 posts
$latestPosts = $postModel->getPosts();
usort($latestPosts, function ($a, $b) {
    return strtotime($b['created_at']) - strtotime($a['created_at']);
});
$displayPosts = array_slice($latestPosts, 0, 8);


?>

<style>
    .scroll-x {
        overflow-x: auto;
        white-space: nowrap;
        padding-bottom: 1rem;
    }

    p,
    h2 {
        color: white;
    }
</style>
<section class="px-2">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-xl lg:text-3xl md:text-2xl font-bold text-white">Latest Posts</h1>
        <a href="last-post"
            class="inline-flex items-center justify-center text-center text-white hover:text-green-400 text-[15px] transition ">
             <?= $lang === 'en' ? 'See More' : 'មើលទាំ' ?>
            <svg class="w-5 h-5 mt-[1px]" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
        </a>
    </div>

    <!-- Desktop grid -->
    <div class="hidden md:grid md:grid-cols-3 lg:grid-cols-4 gap-2">
        <?php foreach ($displayPosts as $p): ?>
            <a href="detail.php?slug=<?= htmlspecialchars($p['slug']) ?>&lang=<?= $lang ?>">
                <div class="card bg-gray-800 rounded-lg shadow-md hover:shadow-lg overflow-hidden">
                    <?php if (!empty($p['image'])): ?>
                        <img src="./admin/posts/uploads/<?= htmlspecialchars($p['image']) ?>"
                            alt="<?= htmlspecialchars($p['name']) ?>"
                            class="w-full h-[90px] md:h-[130px] lg:h-[160px] object-cover rounded-none">
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
            <?php foreach ($displayPosts as $p): ?>
                <a href="detail.php?slug=<?= htmlspecialchars($p['slug']) ?>" class="flex-shrink-0">
                    <div
                        class="card bg-gray-800 rounded-lg shadow-md hover:shadow-lg overflow-hidden w-[167px] sm:w-[200px]">
                        <?php if (!empty($p['image'])): ?>
                            <img src="./admin/posts/uploads/<?= htmlspecialchars($p['image']) ?>"
                                alt="<?= htmlspecialchars($p['name']) ?>"
                                class="w-full h-[90px] sm:h-[120px] object-cover">
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