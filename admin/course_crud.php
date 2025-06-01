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

// Handle course deletion
if (isset($_POST['delete_course'])) {
    $course_id = $_POST['course_id'];
    try {
        // First delete any enrollments for this course
        $stmt = $pdo->prepare("DELETE FROM enrollments WHERE course_id = ?");
        $stmt->execute([$course_id]);
        
        // Then delete the course
        $stmt = $pdo->prepare("DELETE FROM courses WHERE id = ?");
        $stmt->execute([$course_id]);
        
        $success = "Course deleted successfully.";
    } catch (PDOException $e) {
        $err = "Error deleting course: " . $e->getMessage();
    }
}

// Handle course creation/update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['delete_course'])) {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $course_id = $_POST['course_id'] ?? null;

    if (!$title || !$description) {
        $err = 'All fields are required.';
    } else {
        try {
            if ($course_id) {
                // Update existing course
                $stmt = $pdo->prepare("UPDATE courses SET title = ?, description = ? WHERE id = ?");
                $stmt->execute([$title, $description, $course_id]);
                $success = "Course updated successfully.";
            } else {
                // Create new course
                $stmt = $pdo->prepare("INSERT INTO courses (title, description) VALUES (?, ?)");
                $stmt->execute([$title, $description]);
                $success = "Course created successfully.";
            }
        } catch (PDOException $e) {
            $err = "Error saving course: " . $e->getMessage();
        }
    }
}

// Get all courses
try {
    $stmt = $pdo->query("SELECT * FROM courses ORDER BY id DESC");
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $err = "Error fetching courses: " . $e->getMessage();
}

require_once __DIR__ . '/includes/header.php';
?>

<?php if ($err): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($err) ?></div>
<?php endif; ?>

<?php if ($success): ?>
    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<div class="row">
    <!-- Add/Edit Course Form -->
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h3 class="h5 mb-0">Add New Course</h3>
            </div>
            <div class="card-body">
                <form method="post" class="needs-validation" novalidate>
                    <input type="hidden" name="course_id" id="course_id">
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" id="course_title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="course_description" class="form-control" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-save"></i> Save Course
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Courses List -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="h5 mb-0">All Courses</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($courses as $course): ?>
                                <tr>
                                    <td><?= htmlspecialchars($course['id']) ?></td>
                                    <td><?= htmlspecialchars($course['title']) ?></td>
                                    <td><?= htmlspecialchars($course['description']) ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-primary edit-course" 
                                                data-id="<?= $course['id'] ?>"
                                                data-title="<?= htmlspecialchars($course['title']) ?>"
                                                data-description="<?= htmlspecialchars($course['description']) ?>">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <form method="post" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this course?');">
                                            <input type="hidden" name="course_id" value="<?= $course['id'] ?>">
                                            <button type="submit" name="delete_course" class="btn btn-sm btn-danger">
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
    </div>
</div>

<script>
document.querySelectorAll('.edit-course').forEach(button => {
    button.addEventListener('click', function() {
        const id = this.dataset.id;
        const title = this.dataset.title;
        const description = this.dataset.description;
        
        document.getElementById('course_id').value = id;
        document.getElementById('course_title').value = title;
        document.getElementById('course_description').value = description;
        
        // Scroll to form
        document.querySelector('.card').scrollIntoView({ behavior: 'smooth' });
    });
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
