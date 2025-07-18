<?php
session_start();
if (!isset($_SESSION['role'])) {
  header("Location: ../login.html");
  exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View Purchases</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
  <h2 class="mb-4">Purchase Records</h2>
  <a href="../php/logout.php" class="btn btn-danger mb-3">Logout</a>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>ID</th><th>Product</th><th>Quantity</th><th>Cost</th><th>Date</th>
      </tr>
    </thead>
    <tbody id="purchasesTable">
      <!-- Fill from PHP -->
    </tbody>
  </table>
</body>
</html>
