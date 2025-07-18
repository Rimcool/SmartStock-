<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username']);
  $password = $_POST['password'];
  $role = 'User';  // Always assign "User" role
  
  if (empty($username) || empty($password)) {
    echo "<script>alert('All fields are required.'); window.location.href='../sign-up.html';</script>";
    exit;
  }

  // Hash the password
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

  // Check if username already exists
  $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows > 0) {
    echo "<script>alert('Username already taken.'); window.location.href='../sign-up.html';</script>";
    exit;
  }
  $stmt->close();

  // Insert new user
  $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
  $stmt->bind_param("sss", $username, $hashedPassword, $role);

  if ($stmt->execute()) {
    echo "<script>alert('Account created successfully!'); window.location.href='../login.html';</script>";
  } else {
    echo "<script>alert('Error creating account.'); window.location.href='../sign-up.html';</script>";
  }

  $stmt->close();
}
$conn->close();
?>
