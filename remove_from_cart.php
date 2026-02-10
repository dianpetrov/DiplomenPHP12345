<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  header("Location: cart.php");
  exit;
}

$menuId = isset($_POST["menu_id"]) ? (int)$_POST["menu_id"] : 0;

if ($menuId > 0 && isset($_SESSION["cart"][$menuId])) {
  unset($_SESSION["cart"][$menuId]);
}

header("Location: cart.php");
exit;
