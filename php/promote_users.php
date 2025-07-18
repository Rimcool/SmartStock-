<?php
session_start();
if (!isset($_SESSION['role'])) {
  header("Location: ../login.html");
  exit;
}
if ($_SESSION['role'] !== 'Admin') {
  header("Location: ../user/index.php");
  exit;
}

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
  $user_id = $_POST['user_id'];

  $stmt = $conn->prepare("UPDATE users SET role = 'Admin' WHERE id = ?");
  $stmt->bind_param("i", $user_id);
  if ($stmt->execute()) {
    echo "<script>alert('User promoted to Admin successfully'); window.location.href='../admin/manage_users.php';</script>";
  } else {
    echo "<script>alert('Promotion failed'); window.location.href='../admin/manage_users.php';</script>";
  }
  $stmt->close();
}
$conn->close();
?>
