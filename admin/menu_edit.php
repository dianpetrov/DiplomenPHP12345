<?php
require_once __DIR__ . "/admin_only.php";
require_once __DIR__ . "/../database.php"; // $conn

$id = (int)($_GET["id"] ?? 0);
if ($id <= 0) { die("Invalid id"); }

// категории за dropdown
$cats = [];
$resCats = mysqli_query($conn, "SELECT category_id, name FROM categories ORDER BY name");
while($row = mysqli_fetch_assoc($resCats)) $cats[] = $row;

// взимаме продукта
$sql = "SELECT * FROM menu WHERE menu_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$item = mysqli_fetch_assoc($res);

if (!$item) { die("Product not found"); }

$error = "";

if (isset($_POST["save"])) {
  $category_id = (int)($_POST["category_id"] ?? 0);
  $menu_name = trim($_POST["menu_name"] ?? "");
  $description = trim($_POST["description"] ?? "");
  $price = (float)($_POST["price"] ?? 0);
  $is_available = isset($_POST["is_available"]) ? 1 : 0;

  if ($category_id <= 0 || $menu_name === "" || $price <= 0) {
    $error = "Попълни: категория, име и цена > 0.";
  } else {
    $imagePath = $item["menu_image"]; // ако не качим нова снимка, пазим старата

    // ако има нова снимка
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
          // трием старата снимка (ако има)
          if (!empty($item["menu_image"])) {
            $oldFull = __DIR__ . "/../" . $item["menu_image"];
            if (is_file($oldFull)) @unlink($oldFull);
          }
          $imagePath = "uploads/menu/" . $newName;
        } else {
          $error = "Не успях да кача снимката.";
        }
      }
    }

    if ($error === "") {
      $sqlU = "UPDATE menu
               SET category_id=?, menu_name=?, description=?, price=?, menu_image=?, is_available=?
               WHERE menu_id=?";
      $stmtU = mysqli_prepare($conn, $sqlU);
      $descVal = ($description !== "") ? $description : null;

      mysqli_stmt_bind_param(
        $stmtU,
        "issdsii",
        $category_id,
        $menu_name,
        $descVal,
        $price,
        $imagePath,
        $is_available,
        $id
      );

      mysqli_stmt_execute($stmtU);

      header("Location: menu.php");
      exit;
    }
  }
}
?>
<!doctype html>
<html lang="bg">
<head>
  <meta charset="utf-8">
  <title>Edit product</title>
  <style>
    body{font-family:Arial; padding:20px;}
input:not([type="checkbox"]), textarea, select { width:100%; padding:8px; }
input[type="checkbox"] { width:auto; padding:0; }
.grid{display:grid; grid-template-columns:1fr 1fr; gap:10px;}
.btn{padding:10px 14px; cursor:pointer;}
img{width:90px; height:90px; object-fit:cover; border-radius:10px;}
  </style>
</head>
<body>
  <p><a href="menu.php">← back</a></p>
  <h2>Edit продукт</h2>

  <?php if($error): ?>
    <p style="color:red;"><?= htmlspecialchars($error) ?></p>
  <?php endif; ?>

  <form method="post" enctype="multipart/form-data">
    <div class="grid">
      <div>
        <label>Категория</label>
        <select name="category_id" required>
          <?php foreach($cats as $c): ?>
            <option value="<?= (int)$c["category_id"] ?>" <?= ((int)$item["category_id"] === (int)$c["category_id"]) ? "selected" : "" ?>>
              <?= htmlspecialchars($c["name"]) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div>
        <label>Цена</label>
        <input type="number" step="0.01" min="0" name="price" value="<?= htmlspecialchars($item["price"]) ?>" required>
      </div>

      <div style="grid-column:1/-1;">
        <label>Име</label>
        <input name="menu_name" value="<?= htmlspecialchars($item["menu_name"]) ?>" required>
      </div>

      <div style="grid-column:1/-1;">
        <label>Описание</label>
        <textarea name="description" rows="3"><?= htmlspecialchars($item["description"] ?? "") ?></textarea>
      </div>

      <div>
        <label>Текуща снимка</label><br>
        <?php if(!empty($item["menu_image"])): ?>
          <img src="../<?= htmlspecialchars($item["menu_image"]) ?>" alt="">
        <?php else: ?>
          <p>-</p>
        <?php endif; ?>
      </div>

      <div>
        <label>Нова снимка (по желание)</label>
        <input type="file" name="menu_image" accept="image/*">
      </div>

      <div style="display:flex; align-items:center; gap:8px;">
    <label for="available">Наличен</label>
    <input type="checkbox" id="available" name="available" value="1">
</div>

    <br>
    <button class="btn" name="save" value="1">Save</button>
    </div>

    </div>
  </form>
</body>
</html>
