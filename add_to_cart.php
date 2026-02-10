<?php
session_start();
require_once "database.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  header("Location: index.php");
  exit;
}

$menuId = isset($_POST["menu_id"]) ? (int)$_POST["menu_id"] : 0;
$qty    = isset($_POST["qty"]) ? (int)$_POST["qty"] : 1;

if ($menuId <= 0) {
  header("Location: index.php");
  exit;
}

if ($qty < 1) $qty = 1;
if ($qty > 50) $qty = 50;

/* Вземаме продукта от базата */
$sql = "SELECT menu_id, menu_name, price, menu_image FROM menu WHERE menu_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $menuId);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$product = mysqli_fetch_assoc($res);

if (!$product) {
  header("Location: index.php");
  exit;
}

/* Инициализираме количката */
if (!isset($_SESSION["cart"]) || !is_array($_SESSION["cart"])) {
  $_SESSION["cart"] = [];
}

/* Ако вече го има — увеличаваме qty */
if (isset($_SESSION["cart"][$menuId])) {
  $_SESSION["cart"][$menuId]["qty"] += $qty;
} else {
  $_SESSION["cart"][$menuId] = [
    "menu_id" => (int)$product["menu_id"],
    "name"    => $product["menu_name"],
    "price"   => (float)$product["price"],
    "image"   => $product["menu_image"],
    "qty"     => $qty
  ];
}

/* Връщаме към страницата от която е дошъл */
$back = $_SERVER["HTTP_REFERER"] ?? "index.php";
header("Location: " . $back);
exit;
