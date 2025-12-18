<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "inventory_db");

$sql = "SELECT o.order_id, c.customer_name, p.product_name, od.quantity, o.order_date
        FROM orders o
        JOIN customers c ON o.customer_id = c.customer_id
        JOIN orderdetails od ON o.order_id = od.order_id
        JOIN products p ON od.product_id = p.product_id
        ORDER BY o.order_id DESC";

$result = $conn->query($sql);

if (!$result) {
    die("SQL Error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>View Orders</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
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
      max-width: 1100px;
    }
    h3 {
      text-align: center;
      color: #333;
      margin-bottom: 25px;
    }
    .btn i {
      margin-right: 5px;
    }
    .table thead th {
      text-align: center;
    }
    .table tbody td {
      vertical-align: middle;
      text-align: center;
    }
  </style>
</head>
<body>

  <div class="card">
    <h3><i class="bi bi-list-ul"></i> Order List</h3>

    <div class="d-flex justify-content-end mb-3">
      <a href="dashboard.php" class="btn btn-secondary">
        <i class="bi bi-arrow-left-circle"></i> Back to Dashboard
      </a>
    </div>

    <table class="table table-bordered table-striped">
      <thead class="table-primary">
        <tr>
          <th>Order ID</th>
          <th>Customer Name</th>
          <th>Product Name</th>
          <th>Quantity</th>
          <th>Order Date</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result->num_rows > 0): ?>
          <?php while($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= $row['order_id'] ?></td>
              <td><?= htmlspecialchars($row['customer_name']) ?></td>
              <td><?= htmlspecialchars($row['product_name']) ?></td>
              <td><?= $row['quantity'] ?></td>
              <td><?= $row['order_date'] ?></td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="5" class="text-center">No orders found.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

</body>
</html>
