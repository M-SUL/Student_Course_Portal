<?php
session_start();
require_once __DIR__ . '/../db.php';

// Only allow admins to access this page
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: /admin/login.php');
    exit;
}

// Get statistics
try {
    // Total number of students
    $stmt = $pdo->query("SELECT COUNT(*) FROM students");
    $total_students = $stmt->fetchColumn();

    // Total number of courses
    $stmt = $pdo->query("SELECT COUNT(*) FROM courses");
    $total_courses = $stmt->fetchColumn();

    // Total number of enrollments
    $stmt = $pdo->query("SELECT COUNT(*) FROM enrollments");
    $total_enrollments = $stmt->fetchColumn();

    // Most enrolled courses
    $stmt = $pdo->query("
        SELECT c.title, COUNT(e.id) as enrollment_count 
        FROM courses c 
        LEFT JOIN enrollments e ON c.id = e.course_id 
        GROUP BY c.id 
        ORDER BY enrollment_count DESC 
        LIMIT 5
    ");
    $popular_courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Recent enrollments
    $stmt = $pdo->query("
        SELECT e.created_at, s.name as student_name, c.title as course_title
        FROM enrollments e
        JOIN students s ON e.student_id = s.id
        JOIN courses c ON e.course_id = c.id
        ORDER BY e.created_at DESC
        LIMIT 5
    ");
    $recent_enrollments = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    $error = "Error fetching statistics: " . $e->getMessage();
}

require_once __DIR__ . '/includes/header.php';
?>

<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="bi bi-people"></i> Total Students
                </h5>
                <p class="card-text display-6"><?= $total_students ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="bi bi-book"></i> Total Courses
                </h5>
                <p class="card-text display-6"><?= $total_courses ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="bi bi-graph-up"></i> Total Enrollments
                </h5>
                <p class="card-text display-6"><?= $total_enrollments ?></p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Popular Courses -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h3 class="h5 mb-0">Most Popular Courses</h3>
            </div>
            <div class="card-body">
                <div class="list-group">
                    <?php foreach ($popular_courses as $course): ?>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <?= htmlspecialchars($course['title']) ?>
                            <span class="badge bg-primary rounded-pill">
                                <?= $course['enrollment_count'] ?> enrollments
                            </span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Enrollments -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h3 class="h5 mb-0">Recent Enrollments</h3>
            </div>
            <div class="card-body">
                <div class="list-group">
                    <?php foreach ($recent_enrollments as $enrollment): ?>
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1"><?= htmlspecialchars($enrollment['student_name']) ?></h6>
                                <small><?= date('M d, Y', strtotime($enrollment['created_at'])) ?></small>
                            </div>
                            <p class="mb-1"><?= htmlspecialchars($enrollment['course_title']) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="card">
    <div class="card-header">
        <h3 class="h5 mb-0">Quick Actions</h3>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-4">
                <a href="/admin/course_crud.php" class="btn btn-primary w-100">
                    <i class="bi bi-book"></i> Manage Courses
                </a>
            </div>
            <div class="col-md-4">
                <a href="/admin/register.php" class="btn btn-success w-100">
                    <i class="bi bi-person-plus"></i> Register Admin
                </a>
            </div>
            <div class="col-md-4">
                <a href="/index.php" class="btn btn-info w-100">
                    <i class="bi bi-house"></i> View Portal
                </a>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?> 