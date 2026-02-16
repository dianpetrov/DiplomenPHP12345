<?php
session_start();
$cart = $_SESSION["cart"] ?? [];
$total = 0;
foreach ($cart as $item) {
    $total += ((float)$item["price"]) * ((int)$item["qty"]);
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Your Cart - Food Order</title>
    <link rel="stylesheet" href="diplomenPurvaStranica.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body class="cart-body">

<div id="cart-page">
    <div class="cart-header">
        <h2 id="cart-title">Your Cart</h2>
    </div>

    <?php if (empty($cart)): ?>
        <div class="empty-cart">
            <p>Количката е празна.</p>
            <a href="index.php" class="cart-btn">Go to menu</a>
        </div>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <td>Item</td>
                    <td>Name</td>
                    <td>Qty</td>
                    <td>Price</td>
                    <td>Subtotal</td>
                    <td>Remove</td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart as $id => $item): 
                    $subtotal = ((float)$item["price"]) * ((int)$item["qty"]);
                ?>
                <tr>
                    <td>
                        <?php if (!empty($item["image"])): ?>
                            <img src="<?= htmlspecialchars($item["image"]) ?>" alt="" style="width:80px; height:80px; object-fit:cover; border-radius:10px;">
                        <?php endif; ?>
                    </td>
                    <td class="item-name-cell" style="min-width: 150px; max-width: 250px; text-align: left;">
                    <?= htmlspecialchars($item["name"]) ?>
                    </td>
                    <td>
                        <form action="update_cart.php" method="post" class="update-form">
                            <input type="hidden" name="menu_id" value="<?= (int)$item["menu_id"] ?>">
                            <input type="number" name="qty" value="<?= (int)$item["qty"] ?>" min="1" max="50">
                            <button type="submit" class="update-btn" style="margin-left: 5px;">Update</button>
                        </form>
                    </td>
                    <td><?= number_format((float)$item["price"], 2) ?> €</td>
                    <td class="subtotal-cell"><?= number_format($subtotal, 2) ?> €</td>
                    <td>
                        <form action="remove_from_cart.php" method="post">
                            <input type="hidden" name="menu_id" value="<?= (int)$item["menu_id"] ?>">
                            <button type="submit" class="remove-btn">
                                <i class="fa fa-trash-o"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div id="checkout-container">
    <div class="checkout-footer">
        <div class="footer-left">
            <form action="clear_cart.php" method="post">
                <button type="submit" class="btn-secondary">
                    <i class="fa fa-trash"></i> Clear cart
                </button>
            </form>
        </div>

        <div class="footer-right">
            <div class="summary-item">
                <span class="label">Total Items:</span>
                <span class="value"><?= count($cart) ?></span>
            </div>
            <div class="summary-item total-row">
                <span class="label">Total Amount:</span>
                <span class="value total-price"><?= number_format($total, 2) ?> €</span>
            </div>
            <div class="delivery-badge">
                <i class="fa fa-truck"></i> Free Delivery
            </div>
        </div>
    </div>

    <div class="place-order-wrapper">
        <form action="place_order.php" method="post">
            <button type="submit" class="cart-btn place-order">
                PLACE ORDER
            </button>
        </form>
    </div>
</div>
    <?php endif; ?>
</div>

</body>
</html>