<?php
session_start();
$conn = new mysqli("localhost", "root", "", "inventory_db");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $_SESSION["username"] = $username;
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login - Inventory System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Page background gradient */
    body {
      background: linear-gradient(135deg, #667eea, #764ba2);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
    }

    /* Card container */
    .login-card {
      background: #ffffff;
      border-radius: 15px;
      box-shadow: 0 15px 40px rgba(0,0,0,0.25);
      width: 100%;
      max-width: 400px;
      overflow: hidden;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .login-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 20px 50px rgba(0,0,0,0.35);
    }

    /* Card header */
    .login-card-header {
      background: linear-gradient(135deg, #764ba2, #667eea);
      color: #fff;
      text-align: center;
      padding: 1.2rem 0;
      font-size: 1.4rem;
      font-weight: 700;
    }

    /* Card body */
    .login-card-body {
      padding: 2rem;
    }

    /* Form labels */
    .login-card-body label {
      font-weight: 600;
      color: #4b3f9f;
    }

    /* Form inputs */
    .login-card-body input.form-control {
      border-radius: 10px;
      border: 1.5px solid #764ba2;
      padding: 0.6rem 0.8rem;
      margin-bottom: 1rem;
      transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }
    .login-card-body input.form-control:focus {
      border-color: #667eea;
      box-shadow: 0 0 10px rgba(102,126,234,0.5);
      outline: none;
    }

    /* Submit button */
    .login-card-body button.btn-primary {
      width: 100%;
      background: #667eea;
      border: none;
      border-radius: 10px;
      padding: 0.65rem 0;
      font-weight: 600;
      font-size: 1rem;
      transition: all 0.3s ease;
    }
    .login-card-body button.btn-primary:hover {
      background: #5a67d8;
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    /* Error message */
    .alert-danger {
      font-weight: 600;
      background: #ffe6e6;
      color: #c00000;
      border-radius: 10px;
      padding: 0.75rem 1rem;
      margin-bottom: 1rem;
      text-align: center;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    @media(max-width: 480px) {
      .login-card {
        margin: 10px;
      }
    }
  </style>
</head>
<body>
  <div class="login-card">
    <div class="login-card-header">Inventory System Login</div>
    <div class="login-card-body">
      <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
      <form method="POST" autocomplete="off">
        <div class="mb-3">
          <label for="username">Username</label>
          <input id="username" type="text" name="username" class="form-control" required autofocus>
        </div>
        <div class="mb-3">
          <label for="password">Password</label>
          <input id="password" type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
      </form>
    </div>
  </div>
</body>
</html>
