<?php
session_start();
if (!isset($_SESSION["user_id"])) {
  header("Location: login.php");
  exit;
}

require_once "database.php";
$user_id = (int)$_SESSION["user_id"];

$sql = "SELECT order_id, total, status, order_created_at
        FROM orders
        WHERE user_id = ?
        ORDER BY order_created_at DESC";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
?>
<!doctype html>
<html lang="bg">
<head>
  <meta charset="UTF-8">
  <title>Your Orders</title>
  <link rel="stylesheet" href="diplomenPurvaStranica.css">
</head>
<body>

<div style="max-width:1000px; margin:40px auto; padding:20px;">
  <h2>Your Orders</h2>
  <a href="index.php">← Back to shop</a>

  <?php if (mysqli_num_rows($res) == 0): ?>
    <p style="margin-top:16px;">Нямаш поръчки.</p>
  <?php else: ?>
    <?php while ($o = mysqli_fetch_assoc($res)): ?>
      <div style="margin-top:16px; border:1px solid #ddd; border-radius:12px; padding:14px;">
        <b>Order #<?= (int)$o["order_id"] ?></b><br>
        <small><?= htmlspecialchars($o["order_created_at"]) ?></small><br>
        Status: <b><?= htmlspecialchars($o["status"]) ?></b><br>
        Total: <b><?= number_format((float)$o["total"], 2) ?> €</b>
      </div>
    <?php endwhile; ?>
  <?php endif; ?>
</div>

</body>
</html>
