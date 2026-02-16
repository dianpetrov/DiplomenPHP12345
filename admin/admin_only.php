<?php
session_start();
require_once __DIR__ . "/../database.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: ../login.php");
    exit;
}

$user_id = (int)$_SESSION["user_id"];

$sql = "SELECT roles FROM users WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

if (!$user || $user["roles"] !== "admin") {
    http_response_code(403);
    die("Forbidden: Admin only.");
}
