<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include('../lib/users_lib.php');
include('../lib/permission_denied.php');
OnlyRolesAdmin();
$users = new User();

if (!isset($_GET['id'])) {
    echo "<script>alert('Invalid request!'); window.location.href='index.php';</script>";
    exit;
}

$userId = (int)$_GET['id'];

// Target user info
$userInfo = $users->getUserById($userId);
if (!$userInfo) {
    echo "<script>alert('User not found.'); window.location.href='index.php';</script>";
    exit;
}

// Delete user
if ($users->deleteUser($userId)) {
    echo "<script>alert('Deleted successfully!'); window.location.href='index.php';</script>";
} else {
    echo "<script>alert('Error: Unable to delete!'); window.location.href='index.php';</script>";
}
