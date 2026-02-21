<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Register</title>
  <link rel="stylesheet" href="login.css">
</head>
<body>

<div class="login-box">
  <?php
  if (isset($_POST["submit"])) {
    $fullName = $_POST["fullname"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $passwordRepeat = $_POST["repeat_password"];
    $address = $_POST["address"];
    $phone = $_POST["phone"];

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $errors = array();

    if (empty($fullName) || empty($email) || empty($password) || empty($passwordRepeat) || empty($address) || empty($phone)) {
      $errors[] = "All fields are required";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors[] = "Email is not valid";
    }
    if (strlen($password) < 8) {
      $errors[] = "Password must be at least 8 characters long";
    }
    if ($password !== $passwordRepeat) {
      $errors[] = "Password does not match";
    }

    require_once "database.php";

// CHECK EMAIL (prepared)
$sql = "SELECT 1 FROM users WHERE email = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
if (mysqli_num_rows($res) > 0) {
  $errors[] = "Email already exists!";
}

// CHECK PHONE (prepared)
$sql = "SELECT 1 FROM users WHERE phone = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $phone);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
if (mysqli_num_rows($res) > 0) {
  $errors[] = "Phone already exists!";
}

    if (count($errors) > 0) {
      foreach ($errors as $error) {
        echo "<div class='msg msg-error'>$error</div>";
      }
    } else {
      $sql = "INSERT INTO users(user_name, email, password_hash, address, phone, roles)
        VALUES (?, ?, ?, ?, ?, ?)";
$stmt = mysqli_stmt_init($conn);
$prepareStmt = mysqli_stmt_prepare($stmt, $sql);

if ($prepareStmt) {
  $role = "user";
  mysqli_stmt_bind_param($stmt, "ssssss", $fullName, $email, $passwordHash, $address, $phone, $role);
  mysqli_stmt_execute($stmt);
  echo "<div class='msg msg-success'>You are registered successfully.</div>";
} else {
  die("Something went wrong");
      }
    }
  }
  ?>

  <h2>Create account</h2>

  <form action="registration.php" method="post">
    <input type="text" name="fullname" placeholder="Full name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="text" name="address" placeholder="Address" required>
    <input type="text" name="phone" placeholder="Phone" required>
    <input type="password" name="repeat_password" placeholder="Repeat Password" required>

    <button type="submit" class="primary-btn" name="submit">Register</button>
  </form>

  <p class="bottom-text">Already have an account? <a href="login.php">Login</a></p>
</div>

</body>
</html>
