<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  header("Location: cart.php");
  exit;
}

$menuId = isset($_POST["menu_id"]) ? (int)$_POST["menu_id"] : 0;
$qty    = isset($_POST["qty"]) ? (int)$_POST["qty"] : 1;

if ($menuId <= 0) {
  header("Location: cart.php");
  exit;
}

if ($qty < 1) $qty = 1;
if ($qty > 50) $qty = 50;

if (isset($_SESSION["cart"][$menuId])) {
  $_SESSION["cart"][$menuId]["qty"] = $qty;
}

header("Location: cart.php");
exit;
