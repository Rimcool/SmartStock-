<?php
include 'db.php';
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION['role'])) {
  header("Location: ../login.html");
  exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'] ?? '';
  $price = $_POST['price'] ?? 0;
  $quantity = $_POST['quantity'] ?? 0;
  $min_required = $_POST['min_required'] ?? 0;

  // Insert into products
  $stmt = $conn->prepare("INSERT INTO products (name, price, quantity, min_required) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("sdii", $name, $price, $quantity, $min_required);

  if ($stmt->execute()) {
    $product_id = $stmt->insert_id;  // Get the newly added product ID
    $stmt->close();

    // Automatically add to sales table
    $stmt = $conn->prepare("INSERT INTO sales (product_id, quantity, price, sale_date) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("iid", $product_id, $quantity, $price);
    $stmt->execute();
    $stmt->close();

    echo "<script>alert('Product and Sale recorded successfully'); window.location.href='../admin/products.php';</script>";
  } else {
    echo "<script>alert('Error adding product'); window.location.href='../admin/add_product.html';</script>";
  }

  $conn->close();
}
// The HTML for the form will be displayed if it's a GET request (i.e., not a POST)
// You don't need an 'else' block for the GET request if the HTML is below.
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Product</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
  <h2 class="mb-4">Add New Product</h2>
  <form action="add_product.php" method="POST">
    <div class="mb-3">
      <label>Product Name</label>
      <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Price</label>
      <input type="number" step="0.01" name="price" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Quantity</label>
      <input type="number" name="quantity" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Minimum Required</label>
      <input type="number" name="min_required" class="form-control" required>
    </div>
    <button class="btn btn-primary">Add Product</button>
    <a href="../admin/products.php" class="btn btn-secondary">Back</a>
  </form>
</body>
</html>