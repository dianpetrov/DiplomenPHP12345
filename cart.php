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
  <title>Cart</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<div style="max-width:900px; margin:40px auto; padding:24px;">
  <div style="display:flex; justify-content:space-between; align-items:center; gap:12px;">
    <h2 style="margin:0;">Your Cart</h2>
    <a href="index.php" style="text-decoration:none;">← Back to shop</a>
  </div>

  <?php if (empty($cart)): ?>
    <p style="margin-top:16px;">Количката е празна.</p>
  <?php else: ?>
    <table style="width:100%; margin-top:16px; border-collapse:collapse;">
      <thead>
        <tr style="text-align:left; border-bottom:1px solid #ddd;">
          <th style="padding:10px;">Item</th>
          <th style="padding:10px;">Name</th>
          <th style="padding:10px;">Qty</th>
          <th style="padding:10px;">Price</th>
          <th style="padding:10px;">Subtotal</th>
          <th style="padding:10px;">Remove</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($cart as $id => $item): 
          $subtotal = ((float)$item["price"]) * ((int)$item["qty"]);
        ?>
          <tr style="border-bottom:1px solid #eee;">
            <td style="padding:10px;">
              <?php if (!empty($item["image"])): ?>
                <img src="<?= htmlspecialchars($item["image"]) ?>" alt="" style="width:60px; height:60px; object-fit:cover; border-radius:10px;">
              <?php endif; ?>
            </td>
            <td style="padding:10px;"><?= htmlspecialchars($item["name"]) ?></td>

            <td style="padding:10px;">
              <form action="update_cart.php" method="post" style="display:flex; gap:8px; align-items:center;">
                <input type="hidden" name="menu_id" value="<?= (int)$item["menu_id"] ?>">
                <input type="number" name="qty" value="<?= (int)$item["qty"] ?>" min="1" max="50" style="width:70px;">
                <button type="submit" style="padding:6px 10px;">Update</button>
              </form>
            </td>

            <td style="padding:10px;"><?= number_format((float)$item["price"], 2) ?>€</td>
            <td style="padding:10px;"><?= number_format($subtotal, 2) ?>€</td>

            <td style="padding:10px;">
              <form action="remove_from_cart.php" method="post">
                <input type="hidden" name="menu_id" value="<?= (int)$item["menu_id"] ?>">
                <button type="submit" style="padding:6px 10px; background:#e53935; color:#fff; border:0; border-radius:8px;">
                  X
                </button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <div style="margin-top:16px; display:flex; justify-content:space-between; align-items:center;">
      <form action="clear_cart.php" method="post">
        <button type="submit" style="padding:10px 14px;">Clear cart</button>
      </form>

      <div style="font-size:18px;">
        <b>Total:</b> <?= number_format($total, 2) ?> €
      </div>
    </div>

    <!-- Checkout ще го направим след това -->
    <div style="margin-top:16px;">
      <button disabled style="padding:12px 16px; opacity:.6;">
        Checkout (следващата стъпка)
      </button>
    </div>

  <?php endif; ?>
</div>

</body>
</html>
