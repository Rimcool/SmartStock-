<?php
include 'db.php';

$query = "
  SELECT p.name AS product_name, SUM(s.quantity) AS total_sold
  FROM sales s
  JOIN products p ON s.product_id = p.id
  GROUP BY s.product_id
  ORDER BY total_sold DESC
  LIMIT 5
";

$result = $conn->query($query);

$data = [];
while ($row = $result->fetch_assoc()) {
  $data[] = $row;
}

echo json_encode($data);
?>
