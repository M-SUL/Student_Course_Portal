<?php
session_start();
require_once __DIR__ . '/../db.php';

// Only allow admins to access this page
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: /admin/login.php');
    exit;
}

$err = null;
$success = null;

// Handle student deletion
if (isset($_POST['delete_student'])) {
    $student_id = $_POST['student_id'];
    try {
        // First delete any enrollments for this student
        $stmt = $pdo->prepare("DELETE FROM enrollments WHERE student_id = ?");
        $stmt->execute([$student_id]);
        
        // Then delete the student
        $stmt = $pdo->prepare("DELETE FROM students WHERE id = ?");
        $stmt->execute([$student_id]);
        
        $success = "Student deleted successfully.";
    } catch (PDOException $e) {
        $err = "Error deleting student: " . $e->getMessage();
    }
}

// Get all students with their enrollment counts
try {
    $stmt = $pdo->query("
        SELECT s.*, 
               COUNT(e.id) as enrollment_count,
               GROUP_CONCAT(c.title SEPARATOR ', ') as enrolled_courses
        FROM students s
        LEFT JOIN enrollments e ON s.id = e.student_id
        LEFT JOIN courses c ON e.course_id = c.id
        GROUP BY s.id
        ORDER BY s.id DESC
    ");
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $err = "Error fetching students: " . $e->getMessage();
}

require_once __DIR__ . '/includes/header.php';
?>

<?php if ($err): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($err) ?></div>
<?php endif; ?>

<?php if ($success): ?>
    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h3 class="h5 mb-0">Student Management</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Enrollments</th>
                        <th>Enrolled Courses</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $student): ?>
                        <tr>
                            <td><?= htmlspecialchars($student['id']) ?></td>
                            <td><?= htmlspecialchars($student['name']) ?></td>
                            <td><?= htmlspecialchars($student['email']) ?></td>
                            <td>
                                <span class="badge bg-primary">
                                    <?= $student['enrollment_count'] ?> courses
                                </span>
                            </td>
                            <td>
                                <?php if ($student['enrolled_courses']): ?>
                                    <small class="text-muted">
                                        <?= htmlspecialchars($student['enrolled_courses']) ?>
                                    </small>
                                <?php else: ?>
                                    <span class="text-muted">No enrollments</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <form method="post" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this student? This will also remove all their course enrollments.');">
                                    <input type="hidden" name="student_id" value="<?= $student['id'] ?>">
                                    <button type="submit" name="delete_student" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?> 