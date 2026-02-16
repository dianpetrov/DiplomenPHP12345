<?php
session_start();

if (!isset($_SESSION["user_id"])) {
  header("Location: ../login.php");
  exit;
}

require_once __DIR__ . "/../database.php"; // взима $conn

$user_id = (int)$_SESSION["user_id"];

$sql = "SELECT roles, user_name FROM users WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

if (!$user) {
  session_destroy();
  header("Location: ../login.php");
  exit;
}

if ($user["roles"] !== "admin" && $user["roles"] !== "staff") {
  http_response_code(403);
  die("Forbidden: Admin/Staff only.");
}

/* 🔥 СИНХРОНИЗИРАМЕ SESSION С БАЗАТА */
$_SESSION["roles"] = $user["roles"];
$_SESSION["user_name"] = $user["user_name"];

$ADMIN_NAME = $user["user_name"];
$ADMIN_ROLE = $user["roles"];
