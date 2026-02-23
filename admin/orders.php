<?php
require_once __DIR__ . "/admin_staff.php";   // проверка admin + staff
require_once __DIR__ . "/../database.php";   // $conn

$role = $ADMIN_ROLE ?? "";

/*
  admin/orders.php
  - Admin + Staff виждат всички поръчки
  - Могат да сменят статус
  - Само Admin може да трие
*/

// Взимаме всички поръчки + клиент
$sql = "
    SELECT o.order_id, o.user_id, o.total, o.status, o.payment_method, o.payment_status,
        o.pickup_location, o.order_created_at, o.is_delivered,
        u.user_name, u.email
    FROM orders o
    JOIN users u ON u.user_id = o.user_id
    ORDER BY o.order_created_at DESC
";

$res = mysqli_query($conn, $sql);
if (!$res) {
    die("SQL error: " . mysqli_error($conn));
}
?>
<!doctype html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <title>Orders</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<div style="max-width:1100px; margin:40px auto; padding:24px;">
    <div style="display:flex; justify-content:space-between; align-items:center;">
        <h2>Orders</h2>
        <div>
            <a href="index.php">← Admin panel</a>
            |
            <a href="../index.php">Shop</a>
        </div>
    </div>

<?php while ($o = mysqli_fetch_assoc($res)): ?>
<?php $orderId = (int)$o["order_id"]; ?>

<div style="margin-top:20px; border:1px solid #ddd; border-radius:12px; padding:16px;">

    <div style="display:flex; justify-content:space-between; flex-wrap:wrap; gap:20px;">

        <div>
            <b>Order #<?= $orderId ?></b><br>
            <small><?= htmlspecialchars($o["order_created_at"]) ?></small><br>
            Client:
            <b><?= htmlspecialchars($o["user_name"]) ?></b>
            (<?= htmlspecialchars($o["email"]) ?>)
        </div>

        <div>
            <b>Total:</b> <?= number_format((float)$o["total"], 2) ?> лв.<br>
            <b>Pickup:</b> <?= htmlspecialchars($o["pickup_location"]) ?><br>
            <b>Paid:</b> <?= htmlspecialchars($o["payment_status"]) ?>
            (<?= htmlspecialchars($o["payment_method"]) ?>)
        </div>

        <div>
            <b>Status:</b> <?= htmlspecialchars($o["status"]) ?><br>
            <b>Delivered:</b> <?= ((int)$o["is_delivered"] === 1) ? "Yes" : "No" ?>
        </div>

    </div>

    <!-- Items -->
    <?php
    $sqlItems = "
        SELECT oi.quantity, oi.unit_price, m.menu_name
        FROM order_items oi
        JOIN menu m ON m.menu_id = oi.menu_id
        WHERE oi.order_id = ?
    ";

    $stmt = mysqli_prepare($conn, $sqlItems);
    mysqli_stmt_bind_param($stmt, "i", $orderId);
    mysqli_stmt_execute($stmt);
    $itemsRes = mysqli_stmt_get_result($stmt);
    ?>

    <table style="width:100%; margin-top:12px; border-collapse:collapse;">
        <thead>
            <tr style="border-bottom:1px solid #eee;">
                <th align="left">Item</th>
                <th align="left">Qty</th>
                <th align="left">Unit price</th>
                <th align="left">Subtotal</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($it = mysqli_fetch_assoc($itemsRes)): 
            $qty = (int)$it["quantity"];
            $price = (float)$it["unit_price"];
            $sub = $qty * $price;
        ?>
            <tr style="border-bottom:1px solid #f2f2f2;">
                <td><?= htmlspecialchars($it["menu_name"]) ?></td>
                <td><?= $qty ?></td>
                <td><?= number_format($price, 2) ?> лв.</td>
                <td><?= number_format($sub, 2) ?> лв.</td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Actions -->
    <div style="margin-top:12px; display:flex; gap:10px; flex-wrap:wrap;">

        <!-- Update status -->
        <form action="update_order_status.php" method="post">
            <input type="hidden" name="order_id" value="<?= $orderId ?>">
            <select name="status">
                <?php
                $statuses = ["pending","preparing","ready","completed","cancelled"];
                foreach ($statuses as $st):
                    $sel = ($o["status"] === $st) ? "selected" : "";
                ?>
                    <option value="<?= $st ?>" <?= $sel ?>><?= $st ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Update status</button>
        </form>

        <!-- Mark delivered -->
        <?php if ((int)$o["is_delivered"] === 0): ?>
        <form action="mark_delivered.php" method="post">
            <input type="hidden" name="order_id" value="<?= $orderId ?>">
            <button type="submit">Mark delivered</button>
        </form>
        <?php else: ?>
            <span>✅ Delivered</span>
        <?php endif; ?>

        <!-- Delete (admin only) -->
        <?php if ($role === "admin"): ?>
        <form action="delete_order.php" method="post"
            onsubmit="return confirm('Delete this order?');">
            <input type="hidden" name="order_id" value="<?= $orderId ?>">
            <button type="submit"
                    style="background:#e53935; color:white; border:0; padding:6px 10px; border-radius:6px;">
                Delete
            </button>
        </form>
        <?php endif; ?>

    </div>

</div>

<?php endwhile; ?>

</div>
</body>
</html>
