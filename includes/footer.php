</div><!-- /.container -->
</main>

<footer class="bg-primary text-white py-3 mt-auto">
  <div class="container d-flex flex-wrap justify-content-between align-items-center">
    <span>&copy; <?= htmlspecialchars(date('Y')) ?> Student Course Portal</span>
    <!-- quick nav buttons for smaller screens -->
    <div class="btn-group" role="group" aria-label="Footer navigation">
      <a href="/student-portal/index.php" class="btn btn-outline-light btn-sm" aria-label="Home">
        <i class="bi bi-house"></i>
      </a>
      <a href="/student-portal/courses.php" class="btn btn-outline-light btn-sm" aria-label="Courses">
        <i class="bi bi-journal-bookmark"></i>
      </a>
      <?php if (empty($_SESSION['student_id'])): ?>
        <a href="/student-portal/login.php" class="btn btn-outline-light btn-sm" aria-label="Login">
          <i class="bi bi-box-arrow-in-right"></i>
        </a>
      <?php else: ?>
        <a href="/student-portal/dashboard.php" class="btn btn-outline-light btn-sm" aria-label="Dashboard">
          <i class="bi bi-speedometer2"></i>
        </a>
      <?php endif; ?>
    </div>
  </div>
</footer>

<!-- Bootstrap JS bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/assets/script.js"></script>
</body>
</html>