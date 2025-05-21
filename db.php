<?php
$host = 'localhost';
$db = 'student_portal';
$user = 'root';
$pass = 'root'; // Default MAMP password
$port = 8889;   // Default MAMP MySQL port

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;port=$port", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>