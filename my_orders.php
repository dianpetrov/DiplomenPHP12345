<?php
session_start();
require_once "database.php";

/*
  my_orders.php
  Показва поръчките САМО на логнатия потребител:
  - списък с поръчки (orders)
  - към всяка поръчка показва продуктите (order_items + menu)
*/

// 1) Ако не е логнат -> login
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$userId = (int)$_SESSION["user_id"];

// 2) Взимаме всички поръчки на този user
$sqlOrders = "
    SELECT order_id, total, status, pickup_location, order_created_at, is_delivered
    FROM orders
    WHERE user_id = ?
    ORDER BY order_created_at DESC
";

$stmt = mysqli_prepare($conn, $sqlOrders);
if (!$stmt) {
    die("Prepare failed: " . mysqli_error($conn));
}
mysqli_stmt_bind_param($stmt, "i", $userId);
mysqli_stmt_execute($stmt);
$resOrders = mysqli_stmt_get_result($stmt);

// Ще ги съберем в масив
$orders = [];
while ($row = mysqli_fetch_assoc($resOrders)) {
    $orders[] = $row;
}
?>
<!doctype html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div style="max-width:900px; margin:40px auto; padding:24px;">
    <div style="display:flex; justify-content:space-between; align-items:center; gap:12px;">
        <h2 style="margin:0;">My Orders</h2>
        <a href="index.php" style="text-decoration:none;">← Back to shop</a>
    </div>

    <?php if (empty($orders)): ?>
        <p style="margin-top:16px;">Нямаш направени поръчки.</p>
    <?php else: ?>

        <?php foreach ($orders as $o): ?>
            <div style="margin-top:16px; border:1px solid #ddd; border-radius:12px; padding:16px;">
                <div style="display:flex; justify-content:space-between; gap:12px; flex-wrap:wrap;">
                    <div>
                        <b>Order #<?= (int)$o["order_id"] ?></b><br>
                        <small><?= htmlspecialchars($o["order_created_at"]) ?></small>
                    </div>

                    <div>
                        <b>Status:</b> <?= htmlspecialchars($o["status"]) ?><br>
                        <b>Total:</b> <?= number_format((float)$o["total"], 2) ?> лв.
                    </div>

                    <div>
                        <b>Pickup:</b> <?= htmlspecialchars($o["pickup_location"]) ?><br>
                        <b>Delivered:</b> <?= ((int)$o["is_delivered"] === 1) ? "Yes" : "No" ?>
                    </div>
                </div>

                <?php
                // 3) За всяка поръчка взимаме продуктите към нея
                $orderId = (int)$o["order_id"];

                $sqlItems = "
                    SELECT oi.menu_id, oi.quantity, oi.unit_price, m.menu_name
                    FROM order_items oi
                    JOIN menu m ON m.menu_id = oi.menu_id
                    WHERE oi.order_id = ?
                    ORDER BY m.menu_name
                ";

                $stmtItems = mysqli_prepare($conn, $sqlItems);
                if (!$stmtItems) {
                    die("Prepare failed (items): " . mysqli_error($conn));
                }

                mysqli_stmt_bind_param($stmtItems, "i", $orderId);
                mysqli_stmt_execute($stmtItems);
                $resItems = mysqli_stmt_get_result($stmtItems);
                ?>

                <div style="margin-top:12px;">
                    <table style="width:100%; border-collapse:collapse;">
                        <thead>
                        <tr style="text-align:left; border-bottom:1px solid #eee;">
                            <th style="padding:8px;">Item</th>
                            <th style="padding:8px;">Qty</th>
                            <th style="padding:8px;">Unit price</th>
                            <th style="padding:8px;">Subtotal</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php while ($it = mysqli_fetch_assoc($resItems)): ?>
                            <?php
                                $qty = (int)$it["quantity"];
                                $unit = (float)$it["unit_price"];
                                $sub = $qty * $unit;
                            ?>
                            <tr style="border-bottom:1px solid #f2f2f2;">
                                <td style="padding:8px;"><?= htmlspecialchars($it["menu_name"]) ?></td>
                                <td style="padding:8px;"><?= $qty ?></td>
                                <td style="padding:8px;"><?= number_format($unit, 2) ?> €</td>
                                <td style="padding:8px;"><?= number_format($sub, 2) ?> €</td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        <?php endforeach; ?>

    <?php endif; ?>
</div>

</body>
</html>
