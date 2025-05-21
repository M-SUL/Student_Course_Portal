<?php
session_start();
require __DIR__ . '/includes/header.php';
require_once __DIR__ . '/db.php';

if (empty($_SESSION['student_id'])) {
    header('Location: /student-portal/login.php');
    exit;
}

// Get student info
$stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$_SESSION['student_id']]);
$student = $stmt->fetch();

// Get enrolled courses with progress
$stmt = $pdo->prepare("
    SELECT c.*, 
           (SELECT COUNT(*) FROM enrollments e2 WHERE e2.course_id = c.id) as total_students
    FROM courses c
    JOIN enrollments e ON c.id = e.course_id
    WHERE e.student_id = ?
");
$stmt->execute([$_SESSION['student_id']]);
$enrolledCourses = $stmt->fetchAll();

// Get recent activity
try {
    $stmt = $pdo->prepare("
        SELECT e.created_at, c.title, 'enrollment' as type
        FROM enrollments e
        JOIN courses c ON e.course_id = c.id
        WHERE e.student_id = ?
        ORDER BY e.created_at DESC
        LIMIT 5
    ");
    $stmt->execute([$_SESSION['student_id']]);
    $recentActivity = $stmt->fetchAll();
} catch (PDOException $e) {
    // If created_at column doesn't exist, get enrollments without timestamp
    $stmt = $pdo->prepare("
        SELECT c.title, 'enrollment' as type
        FROM enrollments e
        JOIN courses c ON e.course_id = c.id
        WHERE e.student_id = ?
        LIMIT 5
    ");
    $stmt->execute([$_SESSION['student_id']]);
    $recentActivity = $stmt->fetchAll();
}
?>

<div class="container py-4">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="display-5 mb-3">Welcome, <?php echo htmlspecialchars($student['name']); ?>!</h1>
            <p class="lead text-muted">Track your learning progress and manage your courses.</p>
        </div>
        <div class="col-md-4 text-md-end">
            <a href="/student-portal/courses.php" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Browse Courses
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-2">Enrolled Courses</h6>
                            <h2 class="mb-0"><?php echo count($enrolledCourses); ?></h2>
                        </div>
                        <i class="bi bi-book fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-2">Learning Streak</h6>
                            <h2 class="mb-0">3 days</h2>
                        </div>
                        <i class="bi bi-graph-up fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-info text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-2">Next Course</h6>
                            <h2 class="mb-0">Web Fundamentals</h2>
                        </div>
                        <i class="bi bi-calendar-check fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enrolled Courses -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Your Courses</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($enrolledCourses)): ?>
                        <div class="text-center py-4">
                            <i class="bi bi-book text-muted fs-1"></i>
                            <p class="mt-3">You haven't enrolled in any courses yet.</p>
                            <a href="/student-portal/courses.php" class="btn btn-primary">Browse Courses</a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Course</th>
                                        <th>Progress</th>
                                        <th>Students</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($enrolledCourses as $course): ?>
                                        <tr>
                                            <td>
                                                <h6 class="mb-0"><?php echo htmlspecialchars($course['title']); ?></h6>
                                                <small class="text-muted"><?php echo htmlspecialchars($course['description']); ?></small>
                                            </td>
                                            <td>
                                                <div class="progress" style="height: 5px;">
                                                    <div class="progress-bar" role="progressbar" style="width: 25%"></div>
                                                </div>
                                                <small class="text-muted">25% Complete</small>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark">
                                                    <i class="bi bi-people"></i> <?php echo $course['total_students']; ?> students
                                                </span>
                                            </td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-outline-primary">Continue Learning</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Recent Activity</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($recentActivity)): ?>
                        <p class="text-muted text-center py-3">No recent activity</p>
                    <?php else: ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($recentActivity as $activity): ?>
                                <div class="list-group-item px-0">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <i class="bi bi-circle-fill text-success"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <p class="mb-0">
                                                <?php if ($activity['type'] === 'enrollment'): ?>
                                                    Enrolled in <strong><?php echo htmlspecialchars($activity['title']); ?></strong>
                                                <?php endif; ?>
                                            </p>
                                            <?php if (isset($activity['created_at'])): ?>
                                                <small class="text-muted">
                                                    <?php echo date('M j, Y g:i A', strtotime($activity['created_at'])); ?>
                                                </small>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>