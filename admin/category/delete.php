<?php
include '../lib/db.php';
include '../lib/category_lib.php';

// Ensure slug is provided
if (!isset($_GET['slug']) || empty($_GET['slug'])) {
    header("Location: category?error=missing_slug");
    exit;
}

$slug = $_GET['slug'];

try {
    $catModel = new Category();

    $cat = $catModel->getCategory($slug);
    if (!$cat) {
        header("Location: category.?error=not_found");
        exit;
    }

    // Delete cat
    $deleted = $catModel->deleteCatbySlug($slug);

    if ($deleted) {
        header("Location: index?success=deleted");
    } else {
        header("Location: index?error=delete_failed");
    }
    exit;
} catch (Exception $e) {
    header("Location: category?error=" . urlencode($e->getMessage()));
    exit;
}
