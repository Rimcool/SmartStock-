<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION['role'])) {
  header("Location: ../login.html");
  exit;
}

?>

<?php include '../php/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sales Management</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
  <h2 class="mb-4">Record New Sale</h2>
  <form action="../php/add_sale.php" method="POST">
    <div class="mb-3">
      <label>Product</label>
      <select name="product_id" class="form-control" required>
        <option value="">Select Product</option>
        <?php
        $res = $conn->query("SELECT id, name FROM products");
        while ($p = $res->fetch_assoc()) {
          echo "<option value='{$p['id']}'>{$p['name']}</option>";
        }
        ?>
      </select>
    </div>
    <div class="mb-3">
      <label>Quantity</label>
      <input type="number" name="quantity" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Record Sale</button>
  </form>

  <hr>
  <h2>Sales Records</h2>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>ID</th>
        <th>Product</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody>
    <?php
    $sql = "SELECT s.id, p.name AS product_name, s.quantity, s.price, s.sale_date 
            FROM sales s 
            JOIN products p ON s.product_id = p.id";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo "<tr>
          <td>{$row['id']}</td>
          <td>{$row['product_name']}</td>
          <td>{$row['quantity']}</td>
          <td>{$row['price']}</td>
          <td>{$row['sale_date']}</td>
        </tr>";
      }
    } else {
      echo "<tr><td colspan='5'>No sales found</td></tr>";
    }
    ?>
    </tbody>
  </table>
</body>
</html>
<?php $conn->close(); ?>
