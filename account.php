<?php
session_start();
if (!isset($_SESSION["user"])) {
  header("Location: login.php");
  exit;
}

require_once "database.php";

$userId = $_SESSION["user"];

// Вземаме данните на логнатия user
$sql = "SELECT user_name, email, address, phone FROM users WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $userId);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

if (!$user) {
  // ако по някаква причина user_id не съществува
  session_destroy();
  header("Location: login.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>My Account</title>
  <link rel="stylesheet" href="style.css">
  <!-- ако искаш може да ползваш и login.css, зависи ти как е по-красиво -->
</head>
<body>

<div style="max-width: 700px; margin: 40px auto; padding: 24px;">
  <h2>My Account</h2>

  <div style="background:#fff; border-radius:12px; padding:20px; margin-top:16px;">
    <p><b>Name:</b> <?= htmlspecialchars($user["user_name"]) ?></p>
    <p><b>Email:</b> <?= htmlspecialchars($user["email"]) ?></p>
    <p><b>Address:</b> <?= htmlspecialchars($user["address"]) ?></p>
    <p><b>Phone:</b> <?= htmlspecialchars($user["phone"]) ?></p>

    <div style="margin-top:18px;">
      <a href="logout.php" style="display:inline-block; padding:10px 16px; background:#e53935; color:#fff; border-radius:10px; text-decoration:none;">
        Logout
      </a>
    </div>
  </div>
</div>

</body>
</html>
