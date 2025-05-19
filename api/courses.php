<?php
require_once __DIR__ . '/../db.php';
header('Content-Type: application/json');

try {
    // First check if the courses table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'courses'");
    if ($stmt->rowCount() === 0) {
        throw new Exception('Courses table does not exist');
    }

    // Then try to fetch the courses
    $stmt = $pdo->query("SELECT id, title, description FROM courses");
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($courses)) {
        // If no courses found, return empty array instead of error
        echo json_encode([]);
    } else {
        echo json_encode($courses);
    }
} catch (Exception $e) {
    error_log("Courses API Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'error' => 'Failed to fetch courses',
        'message' => $e->getMessage()
    ]);
}