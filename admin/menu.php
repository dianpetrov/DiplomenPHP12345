<?php
require_once __DIR__ . "/admin_only.php";
require_once __DIR__ . "/../database.php"; // дава $conn

$error = "";

// Вземаме категории за dropdown
$cats = [];
$catsRes = mysqli_query($conn, "SELECT category_id, name FROM categories ORDER BY name");
while ($row = mysqli_fetch_assoc($catsRes)) {
  $cats[] = $row;
}

// ADD product
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["add_menu"])) {
  $category_id = (int)($_POST["category_id"] ?? 0);
  $menu_name = trim($_POST["menu_name"] ?? "");
  $description = trim($_POST["description"] ?? "");
  $price = (float)($_POST["price"] ?? 0);
  $is_available = isset($_POST["is_available"]) ? 1 : 0;

  if ($category_id <= 0 || $menu_name === "" || $price <= 0) {
    $error = "Попълни: категория, име и цена > 0.";
  } else {

    // upload image (optional)
    $imagePath = null;
    if (!empty($_FILES["menu_image"]["name"])) {
      $allowed = ["image/jpeg" => "jpg", "image/png" => "png", "image/webp" => "webp"];
      $type = $_FILES["menu_image"]["type"] ?? "";

      if (!isset($allowed[$type])) {
        $error = "Снимката трябва да е JPG/PNG/WEBP.";
      } else {
        $ext = $allowed[$type];
        $newName = "menu_" . time() . "_" . bin2hex(random_bytes(4)) . "." . $ext;

        $uploadDir = __DIR__ . "/../uploads/menu/";
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

        $dest = $uploadDir . $newName;
        if (move_uploaded_file($_FILES["menu_image"]["tmp_name"], $dest)) {
          $imagePath = "uploads/menu/" . $newName;
        } else {
          $error = "Не успях да кача снимката.";
        }
      }
    }

    if ($error === "") {
      $sql = "INSERT INTO menu (category_id, menu_name, description, price, menu_image, is_available)
              VALUES (?, ?, ?, ?, ?, ?)";
      $stmt = mysqli_prepare($conn, $sql);

      $descVal = ($description !== "") ? $description : null;

      mysqli_stmt_bind_param($stmt, "issdsi",
        $category_id,
        $menu_name,
        $descVal,
        $price,
        $imagePath,
        $is_available
      );

      mysqli_stmt_execute($stmt);

      header("Location: menu.php");
      exit;
    }
  }
}

// DELETE product
if (isset($_GET["delete"])) {
  $id = (int)$_GET["delete"];

  // Вземаме снимката (за да я изтрием от папката)
  $stmt = mysqli_prepare($conn, "SELECT menu_image FROM menu WHERE menu_id = ?");
  mysqli_stmt_bind_param($stmt, "i", $id);
  mysqli_stmt_execute($stmt);
  $res = mysqli_stmt_get_result($stmt);
  $row = mysqli_fetch_assoc($res);
  $img = $row["menu_image"] ?? null;

  // Трием продукта
  $stmt2 = mysqli_prepare($conn, "DELETE FROM menu WHERE menu_id = ?");
  mysqli_stmt_bind_param($stmt2, "i", $id);
  mysqli_stmt_execute($stmt2);

  // Трием снимката (ако има)
  if (!empty($img)) {
    $full = __DIR__ . "/../" . $img;
    if (is_file($full)) @unlink($full);
  }

  header("Location: menu.php");
  exit;
}

// LIST products
$items = [];
$sqlItems = "
  SELECT m.menu_id, m.menu_name, m.price, m.is_available, m.menu_image, c.name AS category
  FROM menu m
  JOIN categories c ON c.category_id = m.category_id
  ORDER BY m.menu_id DESC
";
$resItems = mysqli_query($conn, $sqlItems);
while ($row = mysqli_fetch_assoc($resItems)) {
  $items[] = $row;
}
?>
<!doctype html>
<html lang="bg">
<head>
  <meta charset="utf-8">
  <title>Продукти</title>
  <style>
    body{font-family:Arial; padding:20px;}
    table{border-collapse:collapse; width:100%; margin-top:15px;}
    td,th{border:1px solid #ddd; padding:8px; vertical-align:top;}
    input,textarea,select{width:100%; padding:8px;}
    .grid{display:grid; grid-template-columns: 1fr 1fr 1fr; gap:10px;}
    .btn{padding:8px 12px; cursor:pointer;}
    img{width:60px; height:60px; object-fit:cover; border-radius:8px;}
    .danger{color:#b00;}
  </style>
</head>
<body>
  <p><a href="index.php">← back</a></p>
  <h2>Продукти (Menu)</h2>

  <?php if($error): ?>
    <p style="color:red;"><?= htmlspecialchars($error) ?></p>
  <?php endif; ?>

  <form method="post" enctype="multipart/form-data">
    <div class="grid">
      <div>
        <label>Категория</label>
        <select name="category_id" required>
          <option value="">-- избери --</option>
          <?php foreach($cats as $c): ?>
            <option value="<?= (int)$c["category_id"] ?>"><?= htmlspecialchars($c["name"]) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div>
        <label>Име</label>
        <input name="menu_name" required>
      </div>

      <div>
        <label>Цена</label>
        <input name="price" type="number" step="0.01" min="0" required>
      </div>

      <div style="grid-column:1 / -1;">
        <label>Описание</label>
        <textarea name="description" rows="2"></textarea>
      </div>

      <div>
        <label>Снимка</label>
        <input type="file" name="menu_image" accept="image/*">
      </div>

      <div>
        <label>Наличен</label>
        <input type="checkbox" name="is_available" checked>
      </div>

      <div style="display:flex; align-items:end;">
        <button class="btn" name="add_menu" value="1">Добави продукт</button>
      </div>
    </div>
  </form>

  <table>
    <thead>
      <tr>
        <th>ID</th><th>Снимка</th><th>Име</th><th>Категория</th><th>Цена</th><th>Наличен</th><th>Действия</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($items as $it): ?>
        <tr>
          <td><?= (int)$it["menu_id"] ?></td>
          <td>
            <?php if(!empty($it["menu_image"])): ?>
              <img src="../<?= htmlspecialchars($it["menu_image"]) ?>" alt="">
            <?php else: ?>
              -
            <?php endif; ?>
          </td>
          <td><?= htmlspecialchars($it["menu_name"]) ?></td>
          <td><?= htmlspecialchars($it["category"]) ?></td>
          <td><?= number_format((float)$it["price"], 2) ?></td>
          <td><?= ((int)$it["is_available"] === 1) ? "Yes" : "No" ?></td>
          <td>
            <a href="menu_edit.php?id=<?= (int)$it["menu_id"] ?>">Edit</a>
            |
            <a class="danger"
               href="menu.php?delete=<?= (int)$it["menu_id"] ?>"
               onclick="return confirm('Да изтрия ли продукта?')">
              Delete
            </a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</body>
</html>
