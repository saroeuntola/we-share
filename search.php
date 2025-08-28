<?php
include './admin/lib/db.php'; // Make sure dbConn() returns PDO object
header('Content-Type: application/json');

$conn = dbConn(); // PDO object

$q = $_GET['q'] ?? '';
$q = trim($q);

if ($q === '') {
    echo json_encode([]);
    exit;
}

// Use PDO prepared statement
$stmt = $conn->prepare("SELECT name, slug FROM posts WHERE name LIKE :search LIMIT 10");
$searchTerm = "%$q%";
$stmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);

$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($posts);
