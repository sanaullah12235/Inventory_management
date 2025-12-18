<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "inventory_db");
$result = $conn->query("SELECT * FROM suppliers");
?>

<!DOCTYPE html>
<html>
<head>
  <title>View Suppliers</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #f7f9fc, #e2ebf0);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Segoe UI', sans-serif;
    }
    .card {
      padding: 30px;
      border-radius: 20px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.1);
      background-color: #fff;
      width: 100%;
      max-width: 900px;
    }
    h3 {
      text-align: center;
      color: #333;
      margin-bottom: 25px;
    }
    .btn i {
      margin-right: 5px;
    }
    .table thead th, .table tbody td {
      text-align: center;
      vertical-align: middle;
    }
  </style>
</head>
<body>
  <div class="card">
    <h3><i class="bi bi-truck"></i> All Suppliers</h3>

    <div class="d-flex justify-content-end mb-3">
      <a href="dashboard.php" class="btn btn-secondary">
        <i class="bi bi-arrow-left-circle"></i> Back to Dashboard
      </a>
    </div>

    <table class="table table-bordered table-striped">
      <thead class="table-primary">
        <tr>
          <th>Supplier ID</th>
          <th>Name</th>
          <th>Contact Email</th>
          <th>Phone</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result->num_rows > 0): ?>
          <?php while($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= $row['supplier_id'] ?></td>
              <td><?= htmlspecialchars($row['supplier_name']) ?></td>
              <td><?= htmlspecialchars($row['contact_email']) ?></td>
              <td><?= htmlspecialchars($row['phone']) ?></td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="4" class="text-center">No suppliers found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
