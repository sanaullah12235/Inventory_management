<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "inventory_db");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["customer_name"];
    $email = $_POST["email"];
    $address = $_POST["address"];

    $sql = "INSERT INTO customers (customer_name, email, address)
            VALUES ('$name', '$email', '$address')";
    $conn->query($sql);
    $success = "Customer added successfully!";
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Customer</title>
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
    <h3><i class="bi bi-person-plus"></i> Add New Customer</h3>

    <?php if (isset($success)): ?>
      <div class="alert alert-success text-center"><?php echo $success; ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="mb-3">
        <label class="form-label">Customer Name</label>
        <input type="text" name="customer_name" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Address</label>
        <input type="text" name="address" class="form-control" required>
      </div>
      <div class="d-flex justify-content-between">
        <button type="submit" class="btn btn-primary">
          <i class="bi bi-check-circle"></i> Add Customer
        </button>
        <a href="dashboard.php" class="btn btn-secondary">
          <i class="bi bi-arrow-left-circle"></i> Back
        </a>
      </div>
    </form>
  </div>
</body>
</html>
