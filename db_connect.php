<?php
$host = 'localhost';
$dbname = 'ecosort';
$username = 'root';
$password = 'admin1234';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
    echo ""; 
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>