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
  <title>Manage Products</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
  <h2 class="mb-4">Product Management</h2>

  <a href="../php/add_product.php" class="btn btn-success mb-3">Add New Product</a>
  <a href="../php/logout.php" class="btn btn-danger mb-3">Logout</a>

  <table class="table table-bordered">
    <thead>
      <h3>the Data of products</h3>
    </thead>
    <tbody id="productTable">
      <?php include '../php/get_product.php'
 ?>

      <!-- Will fill using PHP or JS (optional AJAX) -->
    </tbody>
  </table>

  <script>
    // If you'd like, we can make this dynamic using PHP directly or JS + PHP call
  </script>
</body>
</html>
