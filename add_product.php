<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "inventory_db");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["product_name"];
    $category = $_POST["category_id"];
    $supplier = $_POST["supplier_id"];
    $quantity = $_POST["quantity"];
    $price = $_POST["price"];

    $sql = "INSERT INTO products (product_name, category_id, supplier_id, quantity_in_stock, unit_price)
            VALUES ('$name', '$category', '$supplier', '$quantity', '$price')";
    $conn->query($sql);
    $success = "Product added successfully!";
}

// Get categories & suppliers for dropdowns
$categories = $conn->query("SELECT * FROM categories");
$suppliers = $conn->query("SELECT * FROM suppliers");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Product</title>
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
      max-width: 600px;
    }
    h3 {
      text-align: center;
      color: #333;
      margin-bottom: 25px;
    }
    .btn-primary i, .btn-secondary i {
      margin-right: 6px;
    }
  </style>
</head>
<body>
  <div class="card">
    <h3><i class="bi bi-box-seam"></i> Add New Product</h3>

    <?php if (isset($success)): ?>
      <div class="alert alert-success text-center"><?php echo $success; ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="mb-3">
        <label class="form-label">Product Name</label>
        <input type="text" name="product_name" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Category</label>
        <select name="category_id" class="form-select" required>
          <option value="">Select Category</option>
          <?php while($row = $categories->fetch_assoc()): ?>
            <option value="<?php echo $row['category_id']; ?>"><?php echo $row['category_name']; ?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Supplier</label>
        <select name="supplier_id" class="form-select" required>
          <option value="">Select Supplier</option>
          <?php while($row = $suppliers->fetch_assoc()): ?>
            <option value="<?php echo $row['supplier_id']; ?>"><?php echo $row['supplier_name']; ?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Quantity in Stock</label>
        <input type="number" name="quantity" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Unit Price</label>
        <input type="number" name="price" step="0.01" class="form-control" required>
      </div>
      <div class="d-flex justify-content-between">
        <button type="submit" class="btn btn-primary">
          <i class="bi bi-check-circle"></i> Add Product
        </button>
        <a href="dashboard.php" class="btn btn-secondary">
          <i class="bi bi-arrow-left-circle"></i> Back
        </a>
      </div>
    </form>
  </div>
</body>
</html>
