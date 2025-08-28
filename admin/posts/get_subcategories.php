<?php
include '../lib/db.php';
include '../lib/subcategory_lib.php';

$subcategoryModel = new Subcategory();
$category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : null;

if ($category_id) {
    // fetch all subcategories under the given category
    $subs = $subcategoryModel->getSubcategoriesByCategory($category_id);
    echo json_encode($subs);
} else {
    echo json_encode([]);
}
