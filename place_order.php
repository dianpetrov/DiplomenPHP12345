<?php
session_start();
require_once "database.php";

/*
  place_order.php
  Какво прави:
  1) Проверява дали потребителя е логнат
  2) Проверява дали количката не е празна
  3) Изчислява total
  4) Създава запис в таблица orders
  5) Записва всеки продукт в таблица order_items
  6) Чисти количката и прехвърля към "my_orders.php"
*/

// 1) Проверка за логнат потребител
// В твоя проект най-вероятно пазиш user_id в session при login.
// Ако при теб е с друго име, кажи ми и ще го сменим.
if (!isset($_SESSION["user_id"])) {
    // ако не е логнат, пращаме към login
    header("Location: login.php");
    exit;
}

// 2) Проверка дали има продукти в количката
$cart = $_SESSION["cart"] ?? [];
if (empty($cart)) {
    header("Location: cart.php");
    exit;
}

$userId = (int)$_SESSION["user_id"];

// 3) Изчисляваме total от количката
$total = 0.0;
foreach ($cart as $item) {
    $qty = (int)$item["qty"];
    $price = (float)$item["price"];
    $total += ($qty * $price);
}

// (по желание) място за взимане - засега го фиксираме
$pickupLocation = "Restaurant";

// 4) Transaction: ако нещо се счупи по средата, да не остане "полу-поръчка"
mysqli_begin_transaction($conn);

try {
    // 5) Създаваме поръчката в orders
    $sqlOrder = "
        INSERT INTO orders (user_id, total, status, pickup_location, payment_method, payment_status)
        VALUES (?, ?, 'pending', ?, 'cash', 'unpaid')
    ";
    $stmtOrder = mysqli_prepare($conn, $sqlOrder);
    if (!$stmtOrder) {
        throw new Exception("Prepare failed (orders): " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmtOrder, "ids", $userId, $total, $pickupLocation);

    if (!mysqli_stmt_execute($stmtOrder)) {
        throw new Exception("Execute failed (orders): " . mysqli_stmt_error($stmtOrder));
    }

    // Взимаме order_id на новата поръчка
    $orderId = mysqli_insert_id($conn);

    // 6) Подготвяме statement за order_items (ще го ползваме в цикъл)
    $sqlItem = "
        INSERT INTO order_items (order_id, menu_id, quantity, unit_price)
        VALUES (?, ?, ?, ?)
    ";
    $stmtItem = mysqli_prepare($conn, $sqlItem);
    if (!$stmtItem) {
        throw new Exception("Prepare failed (order_items): " . mysqli_error($conn));
    }

    // 7) Записваме всеки продукт от cart-а като ред в order_items
    foreach ($cart as $item) {
        $menuId = (int)$item["menu_id"];
        $qty = (int)$item["qty"];
        $price = (float)$item["price"]; // unit_price

        mysqli_stmt_bind_param($stmtItem, "iiid", $orderId, $menuId, $qty, $price);

        if (!mysqli_stmt_execute($stmtItem)) {
            throw new Exception("Execute failed (order_items): " . mysqli_stmt_error($stmtItem));
        }
    }

    // 8) Ако всичко е ок -> commit
    mysqli_commit($conn);

    // 9) Чистим количката
    unset($_SESSION["cart"]);

    // 10) Прехвърляме към страница "моите поръчки"
    header("Location: my_orders.php");
    exit;

} catch (Exception $e) {
    // Ако има грешка -> rollback
    mysqli_rollback($conn);

    // Показваме грешката (за разработка)
    die("Order failed: " . htmlspecialchars($e->getMessage()));
}
