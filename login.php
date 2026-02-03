<?php
session_start();
if (isset($_SESSION["user"])) {
  header("Location: index.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="login.css">
</head>
<body>

<div class="login-box">
  <h2>Login</h2>

  <?php
  if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    require_once "database.php";
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_array($result, MYSQLI_ASSOC);

    if ($user) {
      if (password_verify($password, $user["password_hash"])) {
        $_SESSION["user"] = $user["user_id"];
        $_SESSION["role"] = $user["roles"];
        header("Location: index.php");
        exit;
      } else {
        echo "<div class='msg msg-error'>Password does not match</div>";
      }
    } else {
      echo "<div class='msg msg-error'>Email does not match</div>";
    }
  }
  ?>

  <form action="login.php" method="post">
    <input type="email" name="email" placeholder="Enter Email" required>
    <input type="password" name="password" placeholder="Enter Password" required>

    <button type="submit" class="primary-btn" name="login">Login</button>
  </form>

  <p class="bottom-text">Not registered yet? <a href="registration.php">Register Here</a></p>
</div>

</body>
</html>
