<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database configuration
$host = 'localhost'; // Changed from domain to localhost
$db = 'u743570205_manokamna';
$user = 'u743570205_manokamna';
$pass = 'Anuj@2026@2027';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
     PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
     PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
     PDO::ATTR_EMULATE_PREPARES => false,
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     // For security in production, you might want to log the error and show a generic message
     // throw new \PDOException($e->getMessage(), (int)$e->getCode());
     die("Connection failed: " . $e->getMessage());
}
?>