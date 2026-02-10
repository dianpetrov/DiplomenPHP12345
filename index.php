<?php
session_start();
require_once "database.php";

$cartCount = 0;
if (!empty($_SESSION["cart"])) {
  foreach ($_SESSION["cart"] as $it) {
    $cartCount += (int)$it["qty"];
  }
}


/* Категории */
$categories = [];
$resCat = mysqli_query($conn, "SELECT category_id, name FROM categories ORDER BY name");
while ($row = mysqli_fetch_assoc($resCat)) {
    $categories[] = $row;
}

/* Филтър по категория */
$catId = isset($_GET["cat"]) ? (int)$_GET["cat"] : 0;

/* Продукти */
$products = [];
if ($catId > 0) {
    $stmt = mysqli_prepare(
        $conn,
            "SELECT menu_id, menu_name, price, menu_image, category AS category_id
            FROM menu
            WHERE category = ?
            ORDER BY menu_name"

    );
    mysqli_stmt_bind_param($stmt, "i", $catId);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
} else {
    $res = mysqli_query(
        $conn,
        "SELECT menu_id, menu_name, price, menu_image, category_id
            FROM menu
            ORDER BY menu_name"
    );
}


while ($row = mysqli_fetch_assoc($res)) {
    $products[] = $row;
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

    <!-- LEFT MENU -->
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

    <!-- MIDDLE: PRODUCTS -->
    <div id="food-container">

        <div id="header">
            <div class="add-box">
                <i class="fa fa-map-marker your-address" id="add-address"> Your Address</i>
            </div>

            <div class="util">
                <i class="fa fa-search"> Search</i>
                <i class="fa fa-tags"> Offers</i>
                <a href="cart.php" style="text-decoration:none; color:inherit;">
                    <i class="fa fa-cart-plus" id="cart-plus"> <?= (int)$cartCount ?> Items</i>
                </a>

            </div>
        </div>

        <div id="food-items" class="d-food-items">
            <p id="category-name">
                <?php echo $catId ? "Products" : "All Products"; ?>
            </p>

            <?php if (count($products) === 0): ?>
                <p style="margin:10px;">Няма продукти</p>
            <?php endif; ?>

            <?php foreach ($products as $p): ?>
                <div id="item-card">
                    <div id="cart-top">
                        <span id="rating">★ 4.3</span>
                        <i class="fa fa-heart-o"></i>
                    </div>

                    <img src="<?php echo htmlspecialchars($p["menu_image"]); ?>" alt="">
                    <p id="item-name"><?php echo htmlspecialchars($p["menu_name"]); ?></p>
                    <p id="item-price"><?php echo number_format((float)$p["price"], 2); ?> лв.</p>

                    <form action="add_to_cart.php" method="post" style="margin-top:8px;">
                            <input type="hidden" name="menu_id" value="<?php echo (int)$p["menu_id"]; ?>">
                            <button type="submit" style="padding:8px 10px; border:0; border-radius:10px; cursor:pointer;">Add to cart</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Cart page (ако JS го ползва) -->
        <div id="cart-page" class="cart-toggle">
            <p id="cart-title">Cart Items</p>
            <p id="m-total-amount">Total Amount : 0</p>

            <table>
                <thead>
                <tr>
                    <td>Item</td>
                    <td>Name</td>
                    <td>Quantity</td>
                    <td>Price</td>
                </tr>
                </thead>
                <tbody id="table-body"></tbody>
            </table>

            <div class="btn-box">
                <button class="cart-btn">Checkout</button>
            </div>
        </div>

    </div>

    <!-- RIGHT: CATEGORIES -->
    <div id="cart">

        <div class="taste-header">
            <div class="user">
                <a href="account.php" class="account-pill">
                    <i class="fa fa-user-circle" id="circle"></i>
                    <span><?php echo htmlspecialchars($_SESSION["user_name"] ?? "Account", ENT_QUOTES, 'UTF-8'); ?></span>
                </a>
            </div>
        </div>

        <div id="category-list">
            <p class="item-menu">Go For Hunt</p>
            <div class="border"></div>

            <?php foreach ($categories as $c): ?>
                <div class="list-card">
                    <a class="list-name" href="index.php?cat=<?php echo (int)$c["category_id"]; ?>">
                        <?php echo htmlspecialchars($c["name"]); ?>
                    </a>
                </div>
            <?php endforeach; ?>

            <div class="list-card">
                <a class="list-name" href="index.php">Show all</a>
            </div>
        </div>

        <div id="checkout" class="cart-toggle">
            <p id="total-item">Total Item : 0</p>
            <p id="total-price"></p>
            <p id="delievery">Free delievery on $ 40</p>
            <button class="cart-btn">Checkout</button>
        </div>

    </div>

</div>
<!-- /desktop view -->


<!-- mobile view (оставям твоя както е) -->
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
        <div class="category-header" id="category-header"></div>

        <div id="food-items" class="food-items">
            <div id="biryani" class="m-biryani">
                <p id="category-name">Biryani</p>
            </div>
            <div id="chicken" class="m-chicken">
                <p id="category-name">Chicken Delicious</p>
            </div>
            <div id="paneer" class="m-paneer">
                <p id="category-name">Paneer Mania</p>
            </div>
            <div id="vegetable" class="m-vegetable">
                <p id="category-name">Pure Veg Dishes</p>
            </div>
            <div id="chinese" class="m-chinese">
                <p id="category-name">Chinese Corner</p>
            </div>
            <div id="south-indian" class="m-south-indian">
                <p id="category-name">South Indian</p>
            </div>
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
