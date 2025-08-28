<?php
include '../lib/db.php';
include '../lib/subcategory_lib.php';

// Ensure slug is provided
if (!isset($_GET['slug']) || empty($_GET['slug'])) {
    header("Location: sub-category?error=missing_slug");
    exit;
}

$slug = $_GET['slug'];

try {
    $catModel = new Subcategory();

    // Check if cat exists
    $cat = $catModel->getSubcategory($slug);
    if (!$cat) {
        header("Location: sub-category?error=not_found");
        exit;
    }

    // Delete cat
    $deleted = $catModel->deleteSubcategory($slug);

    if ($deleted) {
        header("Location: index?success=deleted");
    } else {
        header("Location: index?error=delete_failed");
    }
    exit;
} catch (Exception $e) {
    header("Location: cats.php?error=" . urlencode($e->getMessage()));
    exit;
}
