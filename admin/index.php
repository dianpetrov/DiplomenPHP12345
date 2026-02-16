<?php require_once __DIR__ . "/admin_staff.php"; ?> 
<!doctype html>
<html lang="bg">
<head>
  <meta charset="utf-8">
  <title>Admin Panel</title>
  <style>
    body{font-family:Arial; padding:20px;}
    a{display:inline-block; padding:10px 14px; border:1px solid #ccc; border-radius:8px; text-decoration:none; margin-right:10px;}
  </style>
</head>
<body>
  <h2>Admin Panel</h2>
  <p>Здрасти, <?= htmlspecialchars($ADMIN_NAME) ?> (<?= htmlspecialchars($ADMIN_ROLE) ?>)</p>

  <?php
    // Вземаме ролята от guard-а (от базата), а не от session
    $role = $ADMIN_ROLE;
  ?>

  <div style="display:flex; gap:12px; margin-top:20px;">

    <?php if ($role === "admin"): ?>
        <a href="categories.php">Категории</a>
        <a href="menu.php">Продукти (Menu)</a>
    <?php endif; ?>

    <?php if ($role === "admin" || $role === "staff"): ?>
        <a href="orders.php">Поръчки</a>
    <?php endif; ?>


    <a href="../index.php">Back to Shop</a>

    <a href="../logout.php">Logout</a>
    
  </div>

</body>
</html>
