<?php
require_once __DIR__ . "/admin_only.php";
require_once __DIR__ . "/../database.php"; // дава $conn

$error = "";

// ADD
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["add_category"])) {
  $name = trim($_POST["name"] ?? "");
  $desc = trim($_POST["description"] ?? "");

  if ($name === "") {
    $error = "Името е задължително.";
  } else {
    // INSERT (prepared)
    $sql = "INSERT INTO categories (name, description) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    $descVal = ($desc !== "") ? $desc : null;
    mysqli_stmt_bind_param($stmt, "ss", $name, $descVal);

    try {
      mysqli_stmt_execute($stmt);
      header("Location: categories.php");
      exit;
    } catch (Exception $e) {
      $error = "Грешка: " . $e->getMessage();
    }
  }
}

// DELETE
if (isset($_GET["delete"])) {
  $id = (int)$_GET["delete"];

  // Ако има продукти към категорията, FK ще блокира delete (нормално)
  $sql = "DELETE FROM categories WHERE category_id = ?";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "i", $id);

  if (!mysqli_stmt_execute($stmt)) {
    $error = "Не може да се изтрие категория (може да има продукти към нея).";
  } else {
    header("Location: categories.php");
    exit;
  }
}

// LIST
$cats = [];
$res = mysqli_query($conn, "SELECT category_id, name, description, created_at FROM categories ORDER BY name");
while ($row = mysqli_fetch_assoc($res)) {
  $cats[] = $row;
}
?>
<!doctype html>
<html lang="bg">
<head>
<meta charset="utf-8">
<title>Категории</title>
<style>
    body{font-family:Arial; padding:20px;}
    table{border-collapse:collapse; width:100%; margin-top:15px;}
    td,th{border:1px solid #ddd; padding:8px;}
    input{width:100%; padding:8px;}
    .row{display:grid; grid-template-columns: 1fr 2fr auto; gap:10px; align-items:end;}
    .btn{padding:8px 12px; cursor:pointer;}
    .danger{color:#b00;}
</style>
</head>
<body>
<p><a href="index.php">← back</a></p>
<h2>Категории</h2>

<?php if($error): ?>
    <p style="color:red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="post">
    <div class="row">
    <div>
        <label>Име</label>
        <input name="name" required>
    </div>
    <div>
        <label>Описание</label>
        <input name="description">
    </div>
    <div>
        <button class="btn" name="add_category" value="1">Добави</button>
    </div>
    </div>
</form>

<table>
    <thead>
    <tr><th>ID</th><th>Име</th><th>Описание</th><th>Действия</th></tr>
    </thead>
    <tbody>
    <?php foreach($cats as $c): ?>
    <tr>
        <td><?= (int)$c["category_id"] ?></td>
        <td><?= htmlspecialchars($c["name"]) ?></td>
        <td><?= htmlspecialchars($c["description"] ?? "") ?></td>
        <td>
            <a class="danger"
            href="categories.php?delete=<?= (int)$c["category_id"] ?>"
            onclick="return confirm('Да изтрия ли?')">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>
