<?php
include 'db.php';
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
// Check if user is logged in
if (!isset($_SESSION['role'])) {
  header("Location: ../login.html");
  exit;
}
// Total products
$total_products = $conn->query("SELECT COUNT(*) AS total FROM products")->fetch_assoc()['total'];

// Sales and Revenue This Month
$current_month = date('Y-m');
$sales_query = $conn->query("
  SELECT 
    COUNT(*) AS total_sales, 
    SUM(quantity * price) AS total_revenue 
  FROM sales 
  WHERE DATE_FORMAT(sale_date, '%Y-%m') = '$current_month'
");
$sales = $sales_query->fetch_assoc();

// Low stock
$low_stock = $conn->query("SELECT COUNT(*) AS low_count FROM products WHERE quantity < min_required")->fetch_assoc()['low_count'];

echo json_encode([
  "total_products" => $total_products,
  "total_sales" => $sales['total_sales'] ?? 0,
  "total_revenue" => $sales['total_revenue'] ?? 0,
  "low_stock_count" => $low_stock
]);
?>
