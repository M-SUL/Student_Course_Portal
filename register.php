<?php
require __DIR__ . '/includes/header.php';
require_once __DIR__ . '/db.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $pass  = $_POST['password'] ?? '';

    if (!$name || !$email || !$pass) {
        $errors[] = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email format.';
    } elseif (strlen($pass) < 6) {
        $errors[] = 'Password must be at least 6 characters.';
    } else {
        $hash = password_hash($pass, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare("INSERT INTO students (name,email,password) VALUES (?,?,?)");
        try {
            $stmt->execute([$name, $email, $hash]);
            header('Location: /student-portal/login.php?registered=1');
            exit;
        } catch (PDOException $e) {
            $errors[] = 'Email already exists.';
        }
    }
}
?>

<h2 class="mb-4">Student Registration</h2>

<?php if ($errors): ?>
    <div class="alert alert-danger">
        <ul class="mb-0"><?php foreach ($errors as $er) echo "<li>" . htmlspecialchars($er) . "</li>"; ?></ul>
    </div>
<?php endif; ?>

<form method="post" class="row g-3 needs-validation" novalidate>
    <div class="col-12">
        <label class="form-label">Full name</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="col-12">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <div class="col-12">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required minlength="6">
    </div>
    <div class="col-12">
        <button class="btn btn-success w-100" type="submit">
            <i class="bi bi-check-lg"></i> Register
        </button>
    </div>
</form>

<?php require __DIR__ . '/includes/footer.php'; ?>