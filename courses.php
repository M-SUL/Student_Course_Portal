<?php
session_start();
require __DIR__ . '/includes/header.php';
require_once __DIR__ . '/db.php';
$loggedIn = !empty($_SESSION['student_id']);

// Get enrolled courses if logged in
$enrolledCourses = [];
if ($loggedIn) {
    $stmt = $pdo->prepare("SELECT course_id FROM enrollments WHERE student_id = ?");
    $stmt->execute([$_SESSION['student_id']]);
    $enrolledCourses = $stmt->fetchAll(PDO::FETCH_COLUMN);
}
?>

<h2 class="mb-4">Available Courses</h2>
<div id="courseList" class="row g-4"></div>

<script>
// Pass PHP variables to JavaScript
const isLoggedIn = <?php echo $loggedIn ? 'true' : 'false'; ?>;
const enrolledCourses = <?php echo json_encode($enrolledCourses); ?>;

fetch('/student-portal/api/courses.php')
  .then(r => {
      if (!r.ok) {
          throw new Error(`HTTP error! status: ${r.status}`);
      }
      return r.json();
  })
  .then(data => {
      console.log('Fetched courses:', data);
      const wrap = document.getElementById('courseList');
      
      if (data.error) {
          wrap.innerHTML = `<div class="alert alert-danger">${data.message || 'Failed to load courses'}</div>`;
          return;
      }
      
      if (!data.length) {
          wrap.innerHTML = '<div class="alert alert-warning">No courses available.</div>';
          return;
      }
      
      data.forEach(c => {
          const col = document.createElement('div');
          col.className = 'col-12 col-md-6 col-lg-4';
          const isEnrolled = enrolledCourses.includes(parseInt(c.id));
          const btn = isLoggedIn 
            ? `<button class="btn ${isEnrolled ? 'btn-danger' : 'btn-success'} enroll-btn mt-2" data-id="${c.id}">
                <i class="bi ${isEnrolled ? 'bi-x-circle' : 'bi-plus-circle'}"></i> 
                ${isEnrolled ? 'Cancel Enrollment' : 'Enroll'}
               </button>`
            : `<a href="/student-portal/login.php" class="btn btn-primary mt-2">
                <i class="bi bi-box-arrow-in-right"></i> Login to Enroll
               </a>`;
          col.innerHTML = `
            <div class="card shadow-sm h-100">
              <div class="card-body d-flex flex-column">
                <h5 class="card-title">${c.title}</h5>
                <p class="card-text flex-grow-1">${c.description}</p>
                ${btn}
              </div>
            </div>`;
          wrap.appendChild(col);
      });
  })
  .catch(error => {
      console.error('Error fetching courses:', error);
      const wrap = document.getElementById('courseList');
      wrap.innerHTML = `<div class="alert alert-danger">Failed to load courses: ${error.message}</div>`;
  });

<?php if ($loggedIn): ?>
document.addEventListener('click', e => {
    const btn = e.target.closest('.enroll-btn');
    if (!btn) return;

    fetch('/student-portal/ajax/enroll.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ course_id: btn.dataset.id })
    })
    .then(r => {
        if (!r.ok) {
            throw new Error(`HTTP error! status: ${r.status}`);
        }
        return r.json();
    })
    .then(res => {
        if (res.success) {
            if (res.action === 'enrolled') {
                btn.classList.replace('btn-success', 'btn-danger');
                btn.innerHTML = '<i class="bi bi-x-circle"></i> Cancel Enrollment';
            } else {
                btn.classList.replace('btn-danger', 'btn-success');
                btn.innerHTML = '<i class="bi bi-plus-circle"></i> Enroll';
            }
            // Show success message
            const alert = document.createElement('div');
            alert.className = 'alert alert-success alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3';
            alert.innerHTML = `
                ${res.message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            document.body.appendChild(alert);
            setTimeout(() => alert.remove(), 3000);
        } else {
            alert(res.message || 'Operation failed.');
        }
    })
    .catch(error => {
        console.error('Operation error:', error);
        alert('Failed to process request. Please try again.');
    });
});
<?php endif; ?>
</script>

<?php require __DIR__ . '/includes/footer.php'; ?>