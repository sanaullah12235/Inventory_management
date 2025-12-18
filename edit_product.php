<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "inventory_db");

$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch product to edit
$product = $conn->query("SELECT * FROM products WHERE product_id = $product_id")->fetch_assoc();
if (!$product) {
    echo "Product not found.";
    exit();
}

// Get categories and suppliers
$categories = $conn->query("SELECT * FROM categories");
$suppliers = $conn->query("SELECT * FROM suppliers");

// Update product if form submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["product_name"];
    $category = $_POST["category_id"];
    $supplier = $_POST["supplier_id"];
    $quantity = $_POST["quantity"];
    $price = $_POST["price"];

    $update_sql = "UPDATE products SET 
        product_name = '$name', 
        category_id = '$category', 
        supplier_id = '$supplier', 
        quantity_in_stock = '$quantity', 
        unit_price = '$price'
        WHERE product_id = $product_id";

    if ($conn->query($update_sql)) {
        header("Location: view_products.php");
        exit();
    } else {
        $error = "Failed to update product.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Product</title>
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
      background: #fff;
      padding: 30px;
      border-radius: 20px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 600px;
    }
    h3 {
      text-align: center;
      margin-bottom: 25px;
      color: #333;
    }
    .btn i {
      margin-right: 5px;
    }
  </style>
</head>
<body>
  <div class="card">
    <h3><i class="bi bi-pencil-square"></i> Edit Product</h3>
    <?php if (isset($error)): ?>
      <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="mb-3">
        <label class="form-label">Product Name</label>
        <input type="text" name="product_name" class="form-control" value="<?= htmlspecialchars($product['product_name']) ?>" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Category</label>
        <select name="category_id" class="form-select" required>
          <?php while($row = $categories->fetch_assoc()): ?>
            <option value="<?= $row['category_id'] ?>" <?= ($product['category_id'] == $row['category_id']) ? "selected" : "" ?>>
              <?= htmlspecialchars($row['category_name']) ?>
            </option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Supplier</label>
        <select name="supplier_id" class="form-select" required>
          <?php while($row = $suppliers->fetch_assoc()): ?>
            <option value="<?= $row['supplier_id'] ?>" <?= ($product['supplier_id'] == $row['supplier_id']) ? "selected" : "" ?>>
              <?= htmlspecialchars($row['supplier_name']) ?>
            </option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Quantity in Stock</label>
        <input type="number" name="quantity" class="form-control" value="<?= $product['quantity_in_stock'] ?>" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Unit Price</label>
        <input type="number" step="0.01" name="price" class="form-control" value="<?= $product['unit_price'] ?>" required>
      </div>
      <div class="d-flex justify-content-between">
        <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle"></i> Update Product</button>
        <a href="view_products.php" class="btn btn-secondary"><i class="bi bi-x-circle"></i> Cancel</a>
      </div>
    </form>
  </div>
</body>
</html>
