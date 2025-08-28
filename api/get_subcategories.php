<?php
include './admin/lib/db.php';
include './admin/lib/subcategory_lib.php';
include './admin/lib/category_lib.php';

$categoryModel = new Category();
$subcategoryModel = new Subcategory();

$catSlug = $_GET['category'] ?? '';
$cat = $categoryModel->getCategory($catSlug);

$subs = $cat ? $subcategoryModel->getSubcategoriesByCategory($cat['id']) : [];

header('Content-Type: application/json');
echo json_encode($subs);
