<?php
session_start();
if (!isset($_SESSION['role'])) {
  header("Location: ../login.html");
  exit;
}


include '../php/db.php';
?>

<!DOCTYPE html>
<html>
<head>
  <title>Manage Users</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
  <h2 class="mb-4">Manage Users</h2>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Role</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $result = $conn->query("SELECT id, username, role FROM users");
      while ($row = $result->fetch_assoc()) {
        echo "<tr>
          <td>{$row['id']}</td>
          <td>{$row['username']}</td>
          <td>{$row['role']}</td>
          <td>";
        if ($row['role'] !== 'Admin') {
          echo "<form method='POST' action='../php/promote_user.php' style='display:inline-block'>
                  <input type='hidden' name='user_id' value='{$row['id']}'>
                  <button class='btn btn-sm btn-success'>Promote</button>
                </form>";
        } else {
          echo "<span class='text-muted'>Already Admin</span>";
        }
        echo "</td></tr>";
      }
      ?>
    </tbody>
  </table>
</body>
</html>
