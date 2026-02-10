
<?php require_once __DIR__ . "/admin_guard.php"; ?> 
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

  <a href="categories.php">Категории</a>
  <a href="menu.php">Продукти (Menu)</a>
  <a href="../logout.php">Logout</a>
</body>
</html>
