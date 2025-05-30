<?php
// Check if user is logged in as admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: /student-portal/admin/login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Portal</title>
    <link href="/student-portal/assets/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="/student-portal/css/themes.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/student-portal/admin/index.php">Admin Portal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="adminNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/student-portal/admin/index.php">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/student-portal/admin/course_crud.php">
                            <i class="bi bi-book"></i> Manage Courses
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/student-portal/admin/student_management.php">
                            <i class="bi bi-people"></i> Manage Students
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/student-portal/admin/register.php">
                            <i class="bi bi-person-plus"></i> Register Admin
                        </a>
                    </li>
                </ul>
                <div class="navbar-nav">
                    <a class="nav-link" href="/student-portal/index.php" target="_blank">
                        <i class="bi bi-house"></i> View Portal
                    </a>
                    <a class="nav-link" href="/student-portal/logout.php">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>
    <main class="flex-grow-1 py-4">
        <div class="container"> 