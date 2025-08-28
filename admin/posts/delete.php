<?php
include '../lib/db.php';
include '../lib/post_lib.php';

// Ensure slug is provided
if (!isset($_GET['slug']) || empty($_GET['slug'])) {
    header("Location: posts.php?error=missing_slug");
    exit;
}

$slug = $_GET['slug'];

try {
    $postModel = new Post();

    // Check if post exists
    $post = $postModel->getPostBySlug($slug);
    if (!$post) {
        header("Location: posts.php?error=not_found");
        exit;
    }

    // Delete image file from server if it exists
    if (!empty($post['image'])) {
        $imagePath = __DIR__ . '/uploads/' . $post['image']; // Adjust path if necessary
        if (file_exists($imagePath)) {
            unlink($imagePath); // Delete the image
        }
    }

    // Delete post from database
    $deleted = $postModel->deletePostBySlug($slug);

    if ($deleted) {
        header("Location: index.php?success=post_deleted");
    } else {
        header("Location: index.php?error=delete_failed");
    }
    exit;
} catch (Exception $e) {
    header("Location: posts.php?error=" . urlencode($e->getMessage()));
    exit;
}
