<?php
session_start();
require_once "../database.php";

// Само admin/staff
$role = $_SESSION["roles"] ?? "";
if ($role !== "admin" && $role !== "staff") {
    header("Location: ../index.php");
    exit;
}

$orderId = (int)($_POST["order_id"] ?? 0);
if ($orderId <= 0) {
    die("Invalid order.");
}

// Маркираме delivered + (по желание) статус completed
$stmt = mysqli_prepare($conn, "UPDATE orders SET is_delivered = 1, status = 'completed' WHERE order_id = ?");
mysqli_stmt_bind_param($stmt, "i", $orderId);
mysqli_stmt_execute($stmt);

header("Location: orders.php");
exit;
