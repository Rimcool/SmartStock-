<style>
  table {
    width: 80%;
    border-collapse: collapse;
    margin: 20px auto;
  }
  th, td {
    border: 1px solid #ccc;
    padding: 8px 12px;
    text-align: center;
  }
  th {
    background-color: #f5f5f5;
  }
</style>

<table border="1" cellpadding="8" cellspacing="0">
  <tr>
    <th>ID</th>
    <th>Name</th>
    <th>Price</th>
    <th>Quantity</th>
    <th>Min Required</th>
  </tr>
<?php
include 'db.php';  // or your correct path
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../login.html");
  exit;
}
$result = $conn->query("SELECT * FROM products");

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    echo "<tr>
      <td>{$row['id']}</td>
      <td>{$row['name']}</td>
      <td>{$row['price']}</td>
      <td>{$row['quantity']}</td>
      <td>{$row['min_required']}</td>
    </tr>";
  }
} else {
  echo "<tr><td colspan='5'>No products found</td></tr>";
}
$conn->close();
?>
</table>
