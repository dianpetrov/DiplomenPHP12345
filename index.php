<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

require_once "database.php";

/* 1. Взимаме всички категории */
$categories = [];
$resCat = mysqli_query($conn, "SELECT category_id, name FROM categories ORDER BY name");
while ($row = mysqli_fetch_assoc($resCat)) {
    $categories[] = $row;
}

/* 2. Взимаме всички налични продукти */
$products = [];
$sql = "
    SELECT m.menu_id, m.menu_name, m.price, m.menu_image, m.category_id
    FROM menu m
    WHERE m.is_available = 1
";
$resProd = mysqli_query($conn, $sql);
while ($p = mysqli_fetch_assoc($resProd)) {
    $products[$p["category_id"]][] = $p;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="diplomenPurvaStranica.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="register.css">

    <title>User Dashboard</title>
</head>
<body>
    <!-- desktop view -->
    <div class="container" id="container">
        <div id="menu">
            <div class="title">
                <img src="/images/foodie hunter.png" alt="">
            </div>
            <div class="menu-item">
                <a href="#">About</a>
                <a href="#">Services</a>
                <a href="#">Your Orders</a>
                <a href="#">Wishlists</a>
                <a href="#">Cart</a>
                <a href="#">Contact</a>
                <a href="#">Checkout</a>
            </div>
        </div>

        <div id="food-container">
            <div id="header">
                <div class="add-box">
                    <i class="fa fa-map-marker your-address" id="add-address"> Your Address</i>
                </div>
                <div class="util">
                    <i class="fa fa-search"> Search</i>
                    <i class="fa fa-tags"> Offers</i>
                    <i class="fa fa-cart-plus" id="cart-plus"> 0 Items</i>
                </div>
            </div>
            <div id="food-items" class="d-food-items">

                <?php foreach ($categories as $cat): ?>
                    <p id="category-name"><?= htmlspecialchars($cat["name"]) ?></p>

                <?php if (!empty($products[$cat["category_id"]])): ?>
                <?php foreach ($products[$cat["category_id"]] as $item): ?>
                    <div id="item-card">
                        <?php if(!empty($item["menu_image"])): ?>
                        <img src="<?= htmlspecialchars($item["menu_image"]) ?>" alt="">
                        <?php endif; ?>

                        <p id="item-name"><?= htmlspecialchars($item["menu_name"]) ?></p>
                        <p id="item-price">$<?= number_format((float)$item["price"], 2) ?></p>
                    </div>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <p style="margin-left:10px;">Няма продукти</p>
                        <?php endif; ?>

                        <?php endforeach; ?>
                            
                    </div>


        <div id="cart">
            <div class="taste-header">
                <div class="user">
                        <a href="account.php" class="account-pill">
                            <i class="fa fa-user-circle" id="circle"></i>
                            <span>
                                <?php echo htmlspecialchars($_SESSION["user_name"] ?? "Account", ENT_QUOTES, 'UTF-8'); ?>
                            </span>
                            </a>
                                </div>
            </div>
            <div id="category-list">
                <p class="item-menu">Go For Hunt</p>
                <div class="border"></div>                
            </div>
            <div id="checkout" class="cart-toggle">
                <p id="total-item">Total Item : 5</p>
                <p id="total-price"></p>
                <p id="delievery">Free delievery on $ 40</p>
                <button class="cart-btn">Checkout</button>
            </div>
        </div>
    </div>


    <!-- mobile view -->
    <div id="mobile-view" class="mobile-view">
        <div class="mobile-top">
            <div class="logo-box">
                <img src="/images/foodielogo.png" alt="" id="logo">
                <i class="fa fa-map-marker your-address" id="m-add-address"> Your Address</i>
            </div>
            <div class="top-menu">
                <i class="fa fa-search"></i>
                <i class="fa fa-tag"></i>
                <i class="fa fa-heart-o"></i>
                <i class="fa fa-cart-plus" id="m-cart-plus"> 0</i>
            </div>
        </div>
        
        <div class="item-container">
            <div class="category-header" id="category-header">  
            </div>

           <div id="food-items" class="d-food-items">

                <?php foreach ($categories as $cat): ?>
    <p id="category-name"><?= htmlspecialchars($cat["name"]) ?></p>

    <?php if (!empty($products[$cat["category_id"]])): ?>
      <?php foreach ($products[$cat["category_id"]] as $item): ?>
        <div id="item-card">
          <?php if (!empty($item["menu_image"])): ?>
            <img src="<?= htmlspecialchars($item["menu_image"]) ?>" alt="">
          <?php endif; ?>

          <p id="item-name"><?= htmlspecialchars($item["menu_name"]) ?></p>
          <p id="item-price">$<?= number_format((float)$item["price"], 2) ?></p>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p style="margin-left:10px;">Няма продукти</p>
    <?php endif; ?>

  <?php endforeach; ?>

</div>
          
        </div>

        <div class="mobile-footer">
            <p>Home</p>
            <p>Cart</p>
            <p>offers</p>
            <p>orders</p>
        </div>
    </div>
    <script src="/index.js" type="module"></script>
</body>
</html>