<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "inventory_db");

// --- HANDLE FORM SUBMISSION ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST["product_id"];
    $customer_id = $_POST["customer_id"];
    $quantity = $_POST["quantity"];
    $date = date("Y-m-d");

    // Step 1: Insert into orders table
    $order_sql = "INSERT INTO orders (customer_id, order_date) VALUES ('$customer_id', '$date')";
    if ($conn->query($order_sql)) {
        $order_id = $conn->insert_id; // Get the newly inserted order_id

        // Step 2: Insert into orderdetails table
        $detail_sql = "INSERT INTO orderdetails (order_id, product_id, quantity) 
                       VALUES ('$order_id', '$product_id', '$quantity')";

        if ($conn->query($detail_sql)) {
            $msg = "Order placed successfully!";
        } else {
            $msg = "Error inserting order details: " . $conn->error;
        }
    } else {
        $msg = "Error inserting order: " . $conn->error;
    }
}

// --- FETCH PRODUCTS AND CUSTOMERS ---
$products = $conn->query("SELECT * FROM products");
$customers = $conn->query("SELECT * FROM customers");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Order</title>
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
    .btn i {
      margin-right: 5px;
    }
  </style>
</head>
<body>
  <div class="card">
    <h3><i class="bi bi-cart-plus"></i> Place New Order</h3>

    <?php if (isset($msg)): ?>
      <div class="alert alert-info text-center"><?= $msg ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="mb-3">
        <label class="form-label">Product</label>
        <select name="product_id" class="form-select" required>
          <option value="">Select Product</option>
          <?php while ($row = $products->fetch_assoc()): ?>
            <option value="<?= $row['product_id'] ?>"><?= $row['product_name'] ?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Customer</label>
        <select name="customer_id" class="form-select" required>
          <option value="">Select Customer</option>
          <?php while ($row = $customers->fetch_assoc()): ?>
            <option value="<?= $row['customer_id'] ?>"><?= $row['customer_name'] ?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Quantity</label>
        <input type="number" name="quantity" class="form-control" required>
      </div>
      <div class="d-flex justify-content-between">
        <button class="btn btn-success" type="submit">
          <i class="bi bi-check-circle"></i> Place Order
        </button>
        <a href="dashboard.php" class="btn btn-secondary">
          <i class="bi bi-arrow-left-circle"></i> Back
        </a>
      </div>
    </form>
  </div>
</body>
</html>
