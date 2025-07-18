<?php
include 'db.php'; // Make sure this points to your DB connection file
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header("Location: ../login.html");
  exit;
}
$username = $_POST['username'];
$password = $_POST['password'];

// Prepare and run query
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
  $user = $result->fetch_assoc();

  // Verify the password
  if (password_verify($password, $user['password'])) {
    // Start session and set session variables
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];

    // Redirect based on role
    if ($user['role'] === 'admin') {
      header("Location: ../admin/index.php");
    } else {
      header("Location: ../user/index.php");
    }
    exit;
  } else {
    echo "<script>alert('Invalid password'); window.location.href='../login.html';</script>";
  }
} else {
  echo "<script>alert('User not found'); window.location.href='../login.html';</script>";
}

$stmt->close();
$conn->close();
?>
