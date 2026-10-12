<?php
try {
    $pdo = new PDO("mysql:host=127.0.0.1;port=3306", "root", "");
    $pdo->exec("CREATE DATABASE IF NOT EXISTS portfolio_cms CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "Database 'portfolio_cms' created successfully.\n";
    print_r($pdo->query("SHOW DATABASES")->fetchAll(PDO::FETCH_COLUMN));
} catch (Exception $e) {
    echo "Failed: " . $e->getMessage() . "\n";
}
