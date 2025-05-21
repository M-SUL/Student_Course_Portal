<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Student Course Portal</title>

  <!-- Bootstrap 5 CSS & optional icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Custom style for dark/light mode -->
  <link href="/student-portal/css/themes.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">

<!-- ======= NAVBAR ======= -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand fw-bold" href="/student-portal/index.php">Student Portal</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#mainNav" aria-controls="mainNav"
            aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav ms-auto gap-lg-2">
        <li class="nav-item"><a class="nav-link" href="/student-portal/index.php"><i class="bi bi-house"></i> Home</a></li>
        <?php if (empty($_SESSION['student_id'])): ?>
          <li class="nav-item"><a class="nav-link" href="/student-portal/register.php"><i class="bi bi-pencil-square"></i> Register</a></li>
          <li class="nav-item"><a class="nav-link" href="/student-portal/login.php"><i class="bi bi-box-arrow-in-right"></i> Log in</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="/student-portal/dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="/student-portal/courses.php"><i class="bi bi-journal-bookmark"></i> Courses</a></li>
          <li class="nav-item"><a class="nav-link" href="/student-portal/logout.php"><i class="bi bi-box-arrow-right"></i> Log out</a></li>
        <?php endif; ?>
        <li class="nav-item">
          <button id="toggleTheme" class="btn btn-sm btn-light ms-lg-2" title="Switch theme">
              <i class="bi bi-moon-fill"></i>
          </button>
        </li>
      </ul>
    </div>
  </div>
</nav>

<main class="flex-grow-1 py-4">
<div class="container">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/student-portal/js/theme.js"></script>