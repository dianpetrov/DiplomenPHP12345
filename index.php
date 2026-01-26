<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
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

                <div id="biryani" class="d-biryani">
                    <p id="category-name">Biryani</p>

                    <div id="item-card">
                        <div id="cart-top">
                            <i class="fa fa-star" id="rating">4.</i>
                            <i class="fa fa-heart-o add-to-cart"></i>
                        </div>
                        <img src="images\biryani\ambur-chicken-biryani.jpg" alt="">
                        <p id="item-name">Ambur chicken biryani</p>
                        <p id="item-price">Price : $ 7.99</p>
                    </div>

                    <div id="item-card">
                        <div id="cart-top">
                            <i class="fa fa-star" id="rating">4.</i>
                            <i class="fa fa-heart-o add-to-cart"></i>
                        </div>
                        <img src="images\biryani\chicken-biryani.jpg" alt="">
                        <p id="item-name">Chicken biryani</p>
                        <p id="item-price">Price : $ 9.99</p>
                    </div>

                    <div id="item-card">
                        <div id="cart-top">
                            <i class="fa fa-star" id="rating">4.</i>
                            <i class="fa fa-heart-o add-to-cart"></i>
                        </div>
                        <img src="images\biryani\egg-biryani.jpeg" alt="">
                        <p id="item-name">Egg biryani</p>
                        <p id="item-price">Price : $ 6.99</p>
                    </div>

                    <div id="item-card">
                        <div id="cart-top">
                            <i class="fa fa-star" id="rating">4.</i>
                            <i class="fa fa-heart-o add-to-cart"></i>
                        </div>
                        <img src="images\biryani\goan-fish-biryani.jpg" alt="">
                        <p id="item-name">Goan fish biryani</p>
                        <p id="item-price">Price : $ 8.99</p>
                    </div>

                    <div id="item-card">
                        <div id="cart-top">
                            <i class="fa fa-star" id="rating">4.</i>
                            <i class="fa fa-heart-o add-to-cart"></i>
                        </div>
                        <img src="images\biryani\hyd-mutton-biryani.jpg" alt="">
                        <p id="item-name">Hyd mutton biryani</p>
                        <p id="item-price">Price : $ 8.99</p>
                    </div>

                    <div id="item-card">
                        <div id="cart-top">
                            <i class="fa fa-star" id="rating">4.</i>
                            <i class="fa fa-heart-o add-to-cart"></i>
                        </div>
                        <img src="images\biryani\kamrupi-biryani.jpg" alt="">
                        <p id="item-name">Kampuri biryani</p>
                        <p id="item-price">Price : $ 8.99</p>
                    </div>

                    <div id="item-card">
                        <div id="cart-top">
                            <i class="fa fa-star" id="rating">4.</i>
                            <i class="fa fa-heart-o add-to-cart"></i>
                        </div>
                        <img src="images\biryani\kashmiri-pulao.jpg" alt="">
                        <p id="item-name">Kashmiri pulao</p>
                        <p id="item-price">Price : $ 10.99</p>
                    </div>

                    <div id="item-card">
                        <div id="cart-top">
                            <i class="fa fa-star" id="rating">4.</i>
                            <i class="fa fa-heart-o add-to-cart"></i>
                        </div>
                        <img src="images\biryani\memoni-biryani.png" alt="">
                        <p id="item-name">Memoni biryani</p>
                        <p id="item-price">Price : $ 9.99</p>
                    </div>

                    <div id="item-card">
                        <div id="cart-top">
                            <i class="fa fa-star" id="rating">4.</i>
                            <i class="fa fa-heart-o add-to-cart"></i>
                        </div>
                        <img src="images\biryani\mughlai-biryani.jpg" alt="">
                        <p id="item-name">Chicken Curry</p>
                        <p id="item-price">Price : $ 11.99</p>
                    </div>

                </div>

<!-- nova sekciq chicken-->
                <div id="chicken" class="d-chicken">
                    <p id="category-name">Chicken Delicious</p>
                    
                    <div id="item-card">
                        <div id="cart-top">
                            <i class="fa fa-star" id="rating">4.</i>
                            <i class="fa fa-heart-o add-to-cart"></i>
                        </div>
                        <img src="images/chicken/chicken-curry.jpg" alt="">
                        <p id="item-name">Chicken curry</p>
                        <p id="item-price">Price : $ 11.99</p>
                    </div>

                    <div id="item-card">
                        <div id="cart-top">
                            <i class="fa fa-star" id="rating">4.</i>
                            <i class="fa fa-heart-o add-to-cart"></i>
                        </div>
                        <img src="images/chicken/chicken-do-pyaza.jpg" alt="">
                        <p id="item-name">Chicken do pyaza</p>
                        <p id="item-price">Price : $ 13.99

                        </p>
                    </div>

                    <div id="item-card">
                        <div id="cart-top">
                            <i class="fa fa-star" id="rating">4.</i>
                            <i class="fa fa-heart-o add-to-cart"></i>
                        </div>
                        <img src="images/chicken/chicken-masala.jpeg" alt="">
                        <p id="item-name">Chicken masala</p>
                        <p id="item-price">Price : $ 12.99</p>
                    </div>

                    <div id="item-card">
                        <div id="cart-top">
                            <i class="fa fa-star" id="rating">4.</i>
                            <i class="fa fa-heart-o add-to-cart"></i>
                        </div>
                        <img src="images/chicken/chicken-roast.jpg" alt="">
                        <p id="item-name">Chicken roast</p>
                        <p id="item-price">Price : $ 7.99</p>
                    </div>

                    <div id="item-card">
                        <div id="cart-top">
                            <i class="fa fa-star" id="rating">4.</i>
                            <i class="fa fa-heart-o add-to-cart"></i>
                        </div>
                        <img src="images/chicken/handi-chicken.jpg" alt="">
                        <p id="item-name">Handi chicken</p>
                        <p id="item-price">Price : $ 6.99</p>
                    </div>

                    <div id="item-card">
                        <div id="cart-top">
                            <i class="fa fa-star" id="rating">4.</i>
                            <i class="fa fa-heart-o add-to-cart"></i>
                        </div>
                        <img src="images/chicken/murgh-musallam.jpg" alt="">
                        <p id="item-name">Murgh musallam </p>
                        <p id="item-price">Price : $ 8.99</p>
                    </div>

                    <div id="item-card">
                        <div id="cart-top">
                            <i class="fa fa-star" id="rating">4.</i>
                            <i class="fa fa-heart-o add-to-cart"></i>
                        </div>
                        <img src="images/chicken/paneer-butter-masala.jpg" alt="">
                        <p id="item-name">Paneer butter masala</p>
                        <p id="item-price">Price : $ 11.99</p>
                    </div>
                </div>

<!-- nova sekciq chinese -->
                <div id="chinese" class="d-chinese">
                    <p id="category-name">Chinese Corner</p>

                    <div id="item-card">
                        <div id="cart-top">
                            <i class="fa fa-star" id="rating">4.</i>
                            <i class="fa fa-heart-o add-to-cart"></i>
                        </div>
                        <img src="images/chinese/cabbage-momos.jpg" alt="">
                        <p id="item-name">Cabbage mania</p>
                        <p id="item-price">Price : $ 12.99</p>
                    </div>

                    <div id="item-card">
                        <div id="cart-top">
                            <i class="fa fa-star" id="rating">4.</i>
                            <i class="fa fa-heart-o add-to-cart"></i>
                        </div>
                        <img src="images/chinese/chicken-manchurian.jpg" alt="">
                        <p id="item-name">Cabbage mania</p>
                        <p id="item-price">Price : $ 12.99</p>
                    </div>

                    <div id="item-card">
                        <div id="cart-top">
                            <i class="fa fa-star" id="rating">4.</i>
                            <i class="fa fa-heart-o add-to-cart"></i>
                        </div>
                        <img src="images/chinese/chili-chicken.jpg" alt="">
                        <p id="item-name">Cabbage mania</p>
                        <p id="item-price">Price : $ 12.99</p>
                    </div>

                    <div id="item-card">
                        <div id="cart-top">
                            <i class="fa fa-star" id="rating">4.</i>
                            <i class="fa fa-heart-o add-to-cart"></i>
                        </div>
                        <img src="images/chinese/chowmin.jpg" alt="">
                        <p id="item-name">Cabbage mania</p>
                        <p id="item-price">Price : $ 12.99</p>
                    </div>

                    <div id="item-card">
                        <div id="cart-top">
                            <i class="fa fa-star" id="rating">4.</i>
                            <i class="fa fa-heart-o add-to-cart"></i>
                        </div>
                        <img src="images/chinese/mmos.jpg" alt="">
                        <p id="item-name">Mmos</p>
                        <p id="item-price">Price : $ 12.99</p>
                    </div>

                    <div id="item-card">
                        <div id="cart-top">
                            <i class="fa fa-star" id="rating">4.</i>
                            <i class="fa fa-heart-o add-to-cart"></i>
                        </div>
                        <img src="images/chinese/spring-rolls.jpg" alt="">
                        <p id="item-name">Spring rolls</p>
                        <p id="item-price">Price : $ 12.99</p>
                    </div>

                    <div id="item-card">
                        <div id="cart-top">
                            <i class="fa fa-star" id="rating">4.</i>
                            <i class="fa fa-heart-o add-to-cart"></i>
                        </div>
                        <img src="images/chinese/szechuan-chicken.jpg" alt="">
                        <p id="item-name">Szechuan chicken</p>
                        <p id="item-price">Price : $ 12.99</p>
                    </div>

                    <div id="item-card">
                        <div id="cart-top">
                            <i class="fa fa-star" id="rating">4.</i>
                            <i class="fa fa-heart-o add-to-cart"></i>
                        </div>
                        <img src="images/chinese/veg-fried-rice.jpg" alt="">
                        <p id="item-name">Veg fried rice</p>
                        <p id="item-price">Price : $ 12.99</p>
                    </div>
                </div>
<!-- nova sekciq vegetable -->
                <div id="vegetable" class="d-vegetable">
                    <p id="category-name">Vegetable</p>

                    <div id="item-card">
                        <div id="cart-top">
                            <i class="fa fa-star" id="rating">4.</i>
                            <i class="fa fa-heart-o add-to-cart"></i>
                        </div>
                        <img src="images/vegetable/veg-jalfrezi.jpg" alt="">
                        <p id="item-name">Veg jalfrezi</p>
                        <p id="item-price">Price : $ 12.99</p>
                    </div>

                    <div id="item-card">
                        <div id="cart-top">
                            <i class="fa fa-star" id="rating">4.</i>
                            <i class="fa fa-heart-o add-to-cart"></i>
                        </div>
                        <img src="images/vegetable/vegetable-biryani.jpg" alt="">
                        <p id="item-name">Vegetable biryani</p>
                        <p id="item-price">Price : $ 12.99</p>
                    </div>

                    <div id="item-card">
                        <div id="cart-top">
                            <i class="fa fa-star" id="rating">4.</i>
                            <i class="fa fa-heart-o add-to-cart"></i>
                        </div>
                        <img src="images/vegetable/vegetable-curry.jpeg" alt="">
                        <p id="item-name">Vegetable curry</p>
                        <p id="item-price">Price : $ 12.99</p>
                    </div>

                    <div id="item-card">
                        <div id="cart-top">
                            <i class="fa fa-star" id="rating">4.</i>
                            <i class="fa fa-heart-o add-to-cart"></i>
                        </div>
                        <img src="images/vegetable/vegetable-kolhapuri.jpg" alt="">
                        <p id="item-name">Vegetable kolhapuri</p>
                        <p id="item-price">Price : $ 12.99</p>
                    </div>

                    <div id="item-card">
                        <div id="cart-top">
                            <i class="fa fa-star" id="rating">4.</i>
                            <i class="fa fa-heart-o add-to-cart"></i>
                        </div>
                        <img src="images/vegetable/vegetable-masala.jpg" alt="">
                        <p id="item-name">Vegetable masala</p>
                        <p id="item-price">Price : $ 12.99</p>
                    </div>

                    <div id="item-card">
                        <div id="cart-top">
                            <i class="fa fa-star" id="rating">4.</i>
                            <i class="fa fa-heart-o add-to-cart"></i>
                        </div>
                        <img src="images/vegetable/vegetable-pakora.jpg" alt="">
                        <p id="item-name">Vegetabke pakora</p>
                        <p id="item-price">Price : $ 12.99</p>
                    </div>
                </div>

<!-- nova sekciq paneer -->
                <div id="paneer" class="d-paneer">
                    <p id="category-name">Paneer</p>
                    <div id="item-card">
                        <div id="cart-top">
                            <i class="fa fa-star" id="rating">4.</i>
                            <i class="fa fa-heart-o add-to-cart"></i>
                        </div>
                        <img src="images/paneer/matar-paneer.jpg" alt="">
                        <p id="item-name">Matar paneer</p>
                        <p id="item-price">Price : $ 12.99</p>
                    </div>
                    
                    <div id="item-card">
                        <div id="cart-top">
                            <i class="fa fa-star" id="rating">4.</i>
                            <i class="fa fa-heart-o add-to-cart"></i>
                        </div>
                        <img src="images/paneer/palak-paneer.jpg" alt="">
                        <p id="item-name">Palak paneer</p>
                        <p id="item-price">Price : $ 12.99</p>
                    </div>

                    <div id="item-card">
                        <div id="cart-top">
                            <i class="fa fa-star" id="rating">4.</i>
                            <i class="fa fa-heart-o add-to-cart"></i>
                        </div>
                        <img src="images/paneer/paneer-butter-masala.jpg" alt="">
                        <p id="item-name">Paneer butter masala</p>
                        <p id="item-price">Price : $ 12.99</p>
                    </div>

                    <div id="item-card">
                        <div id="cart-top">
                            <i class="fa fa-star" id="rating">4.</i>
                            <i class="fa fa-heart-o add-to-cart"></i>
                        </div>
                        <img src="images/paneer/paneer-do-pyaza.jpg" alt="">
                        <p id="item-name">Paneer do pyaza</p>
                        <p id="item-price">Price : $ 12.99</p>
                    </div>

                    <div id="item-card">
                        <div id="cart-top">
                            <i class="fa fa-star" id="rating">4.</i>
                            <i class="fa fa-heart-o add-to-cart"></i>
                        </div>
                        <img src="images/paneer/paneer-hyderabadi.jpg" alt="">
                        <p id="item-name">Paneer hyderabadi</p>
                        <p id="item-price">Price : $ 12.99</p>
                    </div>

                    <div id="item-card">
                        <div id="cart-top">
                            <i class="fa fa-star" id="rating">4.</i>
                            <i class="fa fa-heart-o add-to-cart"></i>
                        </div>
                        <img src="images/paneer/paneer-lababdar.jpg" alt="">
                        <p id="item-name">Paneer lababdar</p>
                        <p id="item-price">Price : $ 12.99</p>
                    </div>

                    <div id="item-card">
                        <div id="cart-top">
                            <i class="fa fa-star" id="rating">4.</i>
                            <i class="fa fa-heart-o add-to-cart"></i>
                        </div>
                        <img src="images/vegetable/shahi-paneer.jpg" alt="">
                        <p id="item-name">Shani paneer</p>
                        <p id="item-price">Price : $ 12.99</p>
                    </div>
                </div>

                <div id="south-indian" class="d-south-indian">
                    <p id="category-name">South Indian</p>

                    <div id="item-card">
                        <div id="cart-top">
                            <i class="fa fa-star" id="rating">4.</i>
                            <i class="fa fa-heart-o add-to-cart"></i>
                        </div>
                        <img src="images/south indian/butter-masala-dosa.png" alt="">
                        <p id="item-name">Butter masala dosa</p>
                        <p id="item-price">Price : $ 12.99</p>
                    </div>

                    <div id="item-card">
                        <div id="cart-top">
                            <i class="fa fa-star" id="rating">4.</i>
                            <i class="fa fa-heart-o add-to-cart"></i>
                        </div>
                        <img src="images/south indian/idli-with-rice-flour.jpg" alt="">
                        <p id="item-name">Idli with rice flour</p>
                        <p id="item-price">Price : $ 12.99</p>
                    </div>

                    <div id="item-card">
                        <div id="cart-top">
                            <i class="fa fa-star" id="rating">4.</i>
                            <i class="fa fa-heart-o add-to-cart"></i>
                        </div>
                        <img src="images/south indian/masala-dosa.jpg" alt="">
                        <p id="item-name">Masala dosa</p>
                        <p id="item-price">Price : $ 12.99</p>
                    </div>

                    <div id="item-card">
                        <div id="cart-top">
                            <i class="fa fa-star" id="rating">4.</i>
                            <i class="fa fa-heart-o add-to-cart"></i>
                        </div>
                        <img src="images/south indian/mysore-bonda.jpg" alt="">
                        <p id="item-name">Mysore bonda</p>
                        <p id="item-price">Price : $ 12.99</p>
                    </div>

                    <div id="item-card">
                        <div id="cart-top">
                            <i class="fa fa-star" id="rating">4.</i>
                            <i class="fa fa-heart-o add-to-cart"></i>
                        </div>
                        <img src="images/south indian/onion-uttapam.jpg" alt="">
                        <p id="item-name">Onion uttapam</p>
                        <p id="item-price">Price : $ 12.99</p>
                    </div>

                </div>
            </div>

            <div id="cart-page" class="cart-toggle">
                <p id="cart-title">Cart Items</p>
                <p id="m-total-amount">Total Amout : 100</p>
                <table>
                    <thead>
                        <td>Item</td>
                        <td>Name</td>
                        <td>Quantity</td>
                        <td>Price</td>
                    </thead>
                    <tbody id="table-body">
                        
                    </tbody>
                </table>
                <div class="btn-box">
                    <button class="cart-btn">Checkout</button>
                </div>
            </div>
        </div>

        <div id="cart">
            <div class="taste-header">
                <div class="user">
                        <div class="account-pill">
                                <i class="fa fa-user-circle" id="circle"></i>
                                <span><?php echo htmlspecialchars($_SESSION["user_name"] ?? "Account", ENT_QUOTES, 'UTF-8');?></span>
                                </div>
                                <a href="logout.php" class="btn btn-sm btn-danger">Logout</a>
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