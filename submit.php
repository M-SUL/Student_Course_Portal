<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = ""; // your DB password
$dbname = "your_database"; // replace with your DB name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Collect POST data
$fullname = $_POST['fullname'];
$email = $_POST['email'];
$raw_password = $_POST['password'];

// Hash password
$hashed_password = password_hash($raw_password, PASSWORD_DEFAULT);

// Prepare SQL and bind parameters
$stmt = $conn->prepare("INSERT INTO students (fullname, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $fullname, $email, $hashed_password);

if ($stmt->execute()) {
  echo "Registration successful!";
} else {
  echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>