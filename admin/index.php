<?php
session_start();

if (!isset($_SESSION['role'])) {
  if (isset($_COOKIE['remember_token'])) {
    // Validate token and auto-set session
    include 'db.php';
    $stmt = $conn->prepare("SELECT * FROM users WHERE MD5(CONCAT(username, 'secret_key')) = ?");
    $stmt->bind_param("s", $_COOKIE['remember_token']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
      $user = $result->fetch_assoc();
      $_SESSION['username'] = $user['username'];
      $_SESSION['role'] = $user['role'];
    } else {
      header("Location: ../login.html");
      exit;
    }
  } else {
    header("Location: ../login.html");
    exit;
  }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
  <h2 class="mb-4">Admin Dashboard</h2>
  <p>Welcome, admin!</p>

  <div class="list-group">
    <a href="product.php" class="list-group-item list-group-item-action">Manage Products</a>
    <a href="sales.php" class="list-group-item list-group-item-action">View Sales</a>
    <a href="purchases.php" class="list-group-item list-group-item-action">View Purchases</a>
  </div>

  <a href="../php/logout.php" class="btn btn-danger mt-4">Logout</a>
</body>
</html>
