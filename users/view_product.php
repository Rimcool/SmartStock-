<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View Products</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
  <h2>Available Products</h2>
  <a href="index.php" class="btn btn-secondary mb-3">Back</a>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>ID</th><th>Name</th><th>Price</th><th>Quantity</th>
      </tr>
    </thead>
    <tbody>
      <?php
      include '../php/db.php';

      $result = $conn->query("SELECT * FROM products");
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['name']}</td>
            <td>{$row['price']}</td>
            <td>{$row['quantity']}</td>
          </tr>";
        }
      } else {
        echo "<tr><td colspan='4'>No products found</td></tr>";
      }
      $conn->close();
      ?>
    </tbody>
  </table>
</body>
</html>
