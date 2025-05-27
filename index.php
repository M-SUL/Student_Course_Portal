<?php require __DIR__ . '/includes/header.ph<?php require DIR . '/includes/header.php'; ?>

<div class="container text-center py-5">
    <h1 class="display-5 fw-bold">Welcome to the Student Course Portal</h1>
    <p class="lead mb-4">Register for new courses, manage your enrollments, and track your academic journey.</p>

    <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
        <?php if (!isset($_SESSION['student_id'])): ?>
            <a href="register.php" class="btn btn-success btn-lg px-4 gap-2">
                <i class="bi bi-pencil-square"></i> Register
            </a>
            <a href="login.php" class="btn btn-outline-light btn-lg px-4">
                <i class="bi bi-box-arrow-in-right"></i> Log in
            </a>
        <?php else: ?>
            <a href="dashboard.php" class="btn btn-success btn-lg px-4">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="logout.php" class="btn btn-danger btn-lg px-4">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        <?php endif; ?>

        <a href="courses.php" class="btn btn-primary btn-lg px-4">
            <i class="bi bi-journal-bookmark"></i> Browse Courses
        </a>
    </div>
</div>

<?php require DIR . '/includes/footer.php'; ?>