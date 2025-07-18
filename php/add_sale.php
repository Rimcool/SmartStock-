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
  $product_id = $_POST['product_id'];
  $quantity = $_POST['quantity'];

  // Get price and quantity
  $stmt = $conn->prepare("SELECT price, quantity FROM products WHERE id = ?");
  $stmt->bind_param("i", $product_id);
  $stmt->execute();
  $stmt->bind_result($price, $current_quantity);
  $stmt->fetch();
  $stmt->close();

  if ($current_quantity < $quantity) {
    echo "<script>alert('Not enough stock!'); window.location.href='../admin/sales.php';</script>";
    exit;
  }

  // Insert sale
  $stmt = $conn->prepare("INSERT INTO sales (product_id, quantity, price, sale_date) VALUES (?, ?, ?, NOW())");
  $stmt->bind_param("iid", $product_id, $quantity, $price);
  $stmt->execute();
  $stmt->close();

  // Update product stock
  $stmt = $conn->prepare("UPDATE products SET quantity = quantity - ? WHERE id = ?");
  $stmt->bind_param("ii", $quantity, $product_id);
  $stmt->execute();
  $stmt->close();

  echo "<script>alert('Sale recorded successfully!'); window.location.href='../admin/sales.php';</script>";
}
$conn->close();
?>
