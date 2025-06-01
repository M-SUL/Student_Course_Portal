<?php
require __DIR__ . '/includes/header.php';
require_once __DIR__ . '/db.php';

$err = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $pass  = $_POST['password'] ?? '';

    if (!$email || !$pass) {
        $err = 'All fields are required.';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM students WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($pass, $user['password'])) {
            $_SESSION['student_id'] = $user['id'];
            $_SESSION['student_name'] = $user['name'];
            header('Location: /dashboard.php');
            exit;
        } else {
            $err = 'Invalid email or password.';
        }
    }
}
?>

<h2 class="mb-4">Log in</h2>

<?php if (isset($_GET['registered'])): ?>
    <div class="alert alert-success">Registration successful. Please log in.</div>
<?php endif; ?>
<?php if ($err): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($err) ?></div>
<?php endif; ?>

<form method="post" class="row g-3 needs-validation" novalidate>
    <div class="col-12">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <div class="col-12">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <div class="col-12">
        <button class="btn btn-primary w-100" type="submit">
            <i class="bi bi-box-arrow-in-right"></i> Log&nbsp;in
        </button>
    </div>
</form>

<?php require __DIR__ . '/includes/footer.php'; ?>