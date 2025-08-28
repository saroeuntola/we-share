<?php
include './admin/lib/db.php';

try {
    $conn = dbConn();
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $migrations = [
        // Create roles table
        "CREATE TABLE IF NOT EXISTS roles (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(30) NOT NULL UNIQUE,
            slug VARCHAR(50) DEFAULT NULL UNIQUE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

        // Create users table
        "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(191) NOT NULL,
            email VARCHAR(191) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            sex VARCHAR(20) NOT NULL,
            address TEXT NULL,
            city VARCHAR(90) NULL,
            profile TEXT NULL,
            status BOOLEAN NOT NULL DEFAULT true,
            role_id INT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

        // Create user_tokens table
        "CREATE TABLE IF NOT EXISTS user_tokens (
            id INT AUTO_INCREMENT PRIMARY KEY,
            token TEXT NOT NULL,
            user_id INT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

        // Create categories table
        "CREATE TABLE IF NOT EXISTS categories (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(225) NOT NULL UNIQUE,
            name_kh VARCHAR(255) DEFAULT NULL,
            slug VARCHAR(255) DEFAULT NULL UNIQUE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

        // Create subcategories table
        "CREATE TABLE IF NOT EXISTS subcategories (
            id INT AUTO_INCREMENT PRIMARY KEY,
            category_id INT NOT NULL,
            name VARCHAR(225) NOT NULL,
            name_kh VARCHAR(255) DEFAULT NULL,
            slug VARCHAR(255) DEFAULT NULL UNIQUE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

        // Create posts table
        "CREATE TABLE IF NOT EXISTS posts (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(225) NOT NULL,
            name_kh VARCHAR(225) DEFAULT NULL,
            slug VARCHAR(255) DEFAULT NULL UNIQUE,
            image TEXT NULL,
            description TEXT NULL,
            description_kh TEXT DEFAULT NULL,
            category_id INT NOT NULL,
            subcategory_id INT DEFAULT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE,
            FOREIGN KEY (subcategory_id) REFERENCES subcategories(id) ON DELETE SET NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

        // Create brand table
        "CREATE TABLE IF NOT EXISTS brand (
            id INT AUTO_INCREMENT PRIMARY KEY,
            brand_name VARCHAR(125) NOT NULL,
            slug VARCHAR(125) DEFAULT NULL UNIQUE,
            brand_image TEXT NULL,
            link TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
    ];

    // Execute table creation
    foreach ($migrations as $sql) {
        $conn->exec($sql); 
    }

    // Seed default roles if not already present
    $roleCheck = $conn->query("SELECT COUNT(*) FROM roles")->fetchColumn();
    if ($roleCheck == 0) {
        $conn->exec("INSERT INTO roles (name, slug) VALUES ('admin','admin'), ('user','user')");
        echo "✅ Roles seeded.\n";
    }

    echo "✅ Migration completed successfully.\n";

} catch (PDOException $e) {
    echo "❌ Migration failed: " . $e->getMessage() . "\n";
}
