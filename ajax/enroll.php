<?php
session_start();
require_once __DIR__ . '/../db.php';
header('Content-Type: application/json');

if (empty($_SESSION['student_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Please log in first']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$course_id = $data['course_id'] ?? null;

if (!$course_id) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid course ID']);
    exit;
}

try {
    // Check if already enrolled
    $stmt = $pdo->prepare("SELECT id FROM enrollments WHERE student_id = ? AND course_id = ?");
    $stmt->execute([$_SESSION['student_id'], $course_id]);
    $enrollment = $stmt->fetch();

    if ($enrollment) {
        // Cancel enrollment
        $stmt = $pdo->prepare("DELETE FROM enrollments WHERE student_id = ? AND course_id = ?");
        $stmt->execute([$_SESSION['student_id'], $course_id]);
        echo json_encode([
            'success' => true, 
            'message' => 'Enrollment cancelled successfully',
            'action' => 'cancelled'
        ]);
    } else {
        // Create new enrollment
        $stmt = $pdo->prepare("INSERT INTO enrollments (student_id, course_id) VALUES (?, ?)");
        $stmt->execute([$_SESSION['student_id'], $course_id]);
        echo json_encode([
            'success' => true, 
            'message' => 'Successfully enrolled in course',
            'action' => 'enrolled'
        ]);
    }
} catch (Exception $e) {
    error_log("Enrollment Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to process enrollment']);
}