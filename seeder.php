<?php
include './admin/lib/db.php';
try {
    $pdo = dbConn();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $username = 'admin';
    $email = 'admin@.com';
    $password = password_hash('12345678', PASSWORD_BCRYPT); 
    $role_id = 1;

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->fetchColumn() == 0) {
        // Insert admin account
        $stmt = $pdo->prepare("
            INSERT INTO users (username, email, password, sex, role_id, created_at) 
            VALUES (?, ?, ?, 'Male', ?, NOW())
        ");
        $stmt->execute([$username, $email, $password, $role_id]);

        echo "✅ Admin account created successfully.\n";
    } else {
        echo "ℹ️ Admin account already exists.\n";
    }

} catch (PDOException $e) {
    die("❌ Database error: " . $e->getMessage());
}
?>
