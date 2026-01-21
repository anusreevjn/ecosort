<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "PHP is working...<br>";

try {
    $host = 'localhost';
    $dbname = 'ecosort';
    $username = 'root';
    $password = 'admin1234';
    
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    echo "Database connected successfully!<br>";
    
    // Test if tables exist
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll();
    echo "Found " . count($tables) . " tables<br>";
    
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage() . "<br>";
}

echo "Script completed";
?>