<?php
session_start();
require_once "../database.php";

// Само admin
$role = $_SESSION["roles"] ?? "";
if ($role !== "admin") {
    header("Location: ../index.php");
    exit;
}

$orderId = (int)($_POST["order_id"] ?? 0);
if ($orderId <= 0) {
    die("Invalid order.");
}

// Първо трием items, после order (за да няма FK проблеми)
$stmt1 = mysqli_prepare($conn, "DELETE FROM order_items WHERE order_id = ?");
mysqli_stmt_bind_param($stmt1, "i", $orderId);
mysqli_stmt_execute($stmt1);

$stmt2 = mysqli_prepare($conn, "DELETE FROM orders WHERE order_id = ?");
mysqli_stmt_bind_param($stmt2, "i", $orderId);
mysqli_stmt_execute($stmt2);

header("Location: orders.php");
exit;
