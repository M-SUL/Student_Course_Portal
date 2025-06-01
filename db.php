<?php
$host = 'sql109.infinityfree.com';
$db = 'f0_39120594_studentdb';
$user = 'if0_39120594';
$pass = 'w3XaA8wJIuPQN'; // Default MAMP password
$port = 3306;  // Default MAMP MySQL port

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;port=$port", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>