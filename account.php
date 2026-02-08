<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

require_once "database.php";

$userId = (int)$_SESSION["user_id"];

/* Вземаме данните на логнатия user */
$sql = "SELECT user_name, email, address, phone FROM users WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $userId);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    session_destroy();
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div style="max-width:700px; margin:40px auto; padding:24px;">
    <h2>My Account</h2>

    <div style="background:#fff; border-radius:12px; padding:20px; margin-top:16px;">
        <p><b>Name:</b> <?= htmlspecialchars($user["user_name"], ENT_QUOTES, 'UTF-8') ?></p>
        <p><b>Email:</b> <?= htmlspecialchars($user["email"], ENT_QUOTES, 'UTF-8') ?></p>
        <p><b>Address:</b> <?= htmlspecialchars($user["address"], ENT_QUOTES, 'UTF-8') ?></p>
        <p><b>Phone:</b> <?= htmlspecialchars($user["phone"], ENT_QUOTES, 'UTF-8') ?></p>

        <div style="margin-top:18px; display:flex; align-items:center; gap:12px;">
            <a href="logout.php"
              style="padding:10px 16px; background:#e53935; color:#fff; border-radius:10px; text-decoration:none; display:inline-block;">
                Logout
            </a>

            <a href="index.php"
              style="text-decoration:none; color:#e53935; font-weight:500;">
                ← Back to shop
            </a>
        </div>
    </div>
</div>

</body>
</html>
