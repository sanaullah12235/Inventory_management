<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "inventory_db");

// Handle deletion
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $conn->query("DELETE FROM products WHERE product_id = $delete_id");
    header("Location: view_products.php");
    exit();
}

// Fetch products
$sql = "SELECT p.product_id, p.product_name, c.category_name, s.supplier_name, p.quantity_in_stock, p.unit_price
        FROM products p
        LEFT JOIN categories c ON p.category_id = c.category_id
        LEFT JOIN suppliers s ON p.supplier_id = s.supplier_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
  <title>View Products</title>
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
    <h3><i class="bi bi-boxes"></i> Product List</h3>

    <div class="d-flex justify-content-between mb-3">
      <a href="add_product.php" class="btn btn-success">
        <i class="bi bi-plus-circle"></i> Add New Product
      </a>
      <a href="dashboard.php" class="btn btn-secondary">
        <i class="bi bi-arrow-left-circle"></i> Back to Dashboard
      </a>
    </div>

    <table class="table table-bordered table-striped">
      <thead class="table-primary">
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Category</th>
          <th>Supplier</th>
          <th>Quantity</th>
          <th>Unit Price</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result->num_rows > 0): ?>
          <?php while($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?php echo $row['product_id']; ?></td>
              <td><?php echo htmlspecialchars($row['product_name']); ?></td>
              <td><?php echo htmlspecialchars($row['category_name']); ?></td>
              <td><?php echo htmlspecialchars($row['supplier_name']); ?></td>
              <td><?php echo $row['quantity_in_stock']; ?></td>
              <td><?php echo number_format($row['unit_price'], 2); ?></td>
              <td>
                <a href="edit_product.php?id=<?php echo $row['product_id']; ?>" class="btn btn-sm btn-primary">
                  <i class="bi bi-pencil-square"></i> Edit
                </a>
                <a href="view_products.php?delete_id=<?php echo $row['product_id']; ?>" 
                   onclick="return confirm('Are you sure you want to delete this product?');"
                   class="btn btn-sm btn-danger">
                  <i class="bi bi-trash"></i> Delete
                </a>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="7" class="text-center">No products found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
