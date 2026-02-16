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
$status  = trim($_POST["status"] ?? "");

$allowed = ["pending","preparing","ready","completed","cancelled"];
if ($orderId <= 0 || !in_array($status, $allowed, true)) {
    die("Invalid data.");
}

// (по желание) правила за staff (ако искаш да не може cancelled)
if ($role === "staff" && $status === "cancelled") {
    die("Staff cannot cancel orders.");
}

$stmt = mysqli_prepare($conn, "UPDATE orders SET status = ? WHERE order_id = ?");
mysqli_stmt_bind_param($stmt, "si", $status, $orderId);
mysqli_stmt_execute($stmt);

header("Location: orders.php");
exit;
