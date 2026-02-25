<?php
session_start();
require_once "database.php";

if (empty($_SESSION["user_id"])) {
  http_response_code(401);
  die("Login required");
}

$menu_id = (int)($_POST["menu_id"] ?? 0);
$rating  = (int)($_POST["rating"] ?? 0);

if ($menu_id <= 0) die("Invalid menu_id");
if ($rating < 1 || $rating > 5) die("Invalid rating");

$user_id = (int)$_SESSION["user_id"];

// 1 rating на user за продукт (ако има -> update, иначе -> insert)
$stmt = mysqli_prepare($conn, "SELECT review_id FROM reviews WHERE menu_id = ? AND user_id = ? LIMIT 1");
mysqli_stmt_bind_param($stmt, "ii", $menu_id, $user_id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$existing = mysqli_fetch_assoc($res);
mysqli_stmt_close($stmt);

if ($existing) {
  $stmt = mysqli_prepare($conn, "UPDATE reviews SET rating = ?, created_at = NOW() WHERE review_id = ?");
  mysqli_stmt_bind_param($stmt, "ii", $rating, $existing["review_id"]);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
} else {
  $stmt = mysqli_prepare($conn, "INSERT INTO reviews(menu_id, user_id, rating) VALUES (?,?,?)");
  mysqli_stmt_bind_param($stmt, "iii", $menu_id, $user_id, $rating);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
}

$cat = (int)($_POST["cat"] ?? 0);
header("Location: index.php" . ($cat > 0 ? "?cat=".$cat : ""));
exit;