<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
   <style>
    /* Make body and html full height to center content vertically */
    html, body {
      height: 100%;
      margin: 0;
      background: #f0f2f5;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Center the entire page content vertically and horizontally */
    body {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      padding: 20px;
    }

    /* Style the navbar */
    nav.navbar {
      width: 100%;
      max-width: 700px;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
      margin-bottom: 30px;
    }

    .navbar-brand {
      font-weight: 700;
      font-size: 1.8rem;
      color: #fff !important;
    }

    .navbar .text-white {
      font-weight: 600;
    }

    .navbar .text-white a {
      text-decoration: underline;
      color: #fc4f4fff;
      margin-left: 10px;
      transition: color 0.3s ease;
    }

    .navbar .text-white a:hover {
      color: #d1e7ff;
    }

    /* Container for buttons */
    .container.mt-4 {
      display: flex;
      flex-wrap: wrap;
      justify-content: center; /* horizontal center */
      gap: 20px;
      width: 100%;
      max-width: 700px;
    }

    /* Each button column */
    .container.mt-4 .col-md-4 {
      flex: 0 0 auto;
      max-width: 200px;
    }

    /* Buttons style */
    .container.mt-4 a.btn {
      width: 100%;
      font-weight: 600;
      font-size: 1.1rem;
      padding: 14px 0;
      border-radius: 10px;
      transition: all 0.3s ease;
      box-shadow: 0 4px 10px rgba(0,0,0,0.12);
      text-align: center;

      /* Force all buttons to look like first two */
      color: #0d6efd;
      border: 2px solid #0d6efd;
      background-color: transparent;
    }

    /* Hover effect on all buttons */
    .container.mt-4 a.btn:hover {
      box-shadow: 0 8px 15px rgba(0,0,0,0.2);
      transform: translateY(-4px);
      text-decoration: none;
      background-color: #0d6efd;
      color: #fff;
      border-color: #0d6efd;
    }
  </style>
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>
  <nav class="navbar navbar-dark bg-primary">
    <div class="container-fluid">
      <span class="navbar-brand">Inventory Dashboard</span>
      <span class="text-white">Welcome, <?php echo $_SESSION['username']; ?> | <a href="logout.php" class="text-white">Logout</a></span>
    </div>
  </nav>

  <div class="container mt-4">
    <div class="row g-3">
      <div class="col-md-4">
        <a href="add_product.php" class="btn w-100">Add Product</a>
      </div>
      <div class="col-md-4">
        <a href="view_products.php" class="btn w-100">View Products</a>
      </div>
      <div class="col-md-4">
        <a href="add_order.php" class="btn w-100">Add Order</a>
      </div>
      <div class="col-md-4">
        <a href="view_orders.php" class="btn w-100">View Orders</a>
      </div>
      <div class="col-md-4">
       <a href="add_customer.php" class="btn w-100">Add New Customer</a>
      </div>
      <div class="col-md-4">
        <a href="view_customers.php" class="btn w-100">View Customers</a>
      </div>
      <div class="col-md-4" style="justify-content: center">
        <a href="view_suppliers.php" class="btn w-100">View Suppliers</a>
      </div>
    </div>
  </div>
</body>
</html>
