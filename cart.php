<?php
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
    session_start();
    if (!isset($_SESSION['customer'])) {
        header('Location: ./login.php');
    }
    require './class/product-link.class.php';
    require './class/cart.class.php';
    require './product-template.php';
    $product_link = new product_link();
    $cart = new cart();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./asset/ressources/css/style.css">
    <link rel="stylesheet" href="./asset/ressources/css/reset.css">
    <title>Pear</title>
</head>

<body>
    <?php require './view/partials/nav.php' ?>
    <main role="main">
        <div class="container">
            <?php
                $content = $cart->get_cart_content();
                if (isset($content) && !empty($content)) {
                    echo '
                    <div class="text-center pt-2">
                        <button id="validateCart" type="button" class="btn btn-primary mx-auto">Passer commande</button>
                        <p id="totalPriceDisplay">Prix total du panier : '.$cart->get_cart_total_price().'€</p>
                    </div>
                    ';
                }
            ?>
            <div class="row">
                <div class="container pt-5">
                    <?php 
                        $content = $cart->get_cart_content();
                        if (isset($content) && !empty($content)) {
                            foreach ($content as $item) {
                                $product = $product_link->get_product_from_id($item['id']);
                                product_in_cart($product);
                            }
                        } else {
                            echo "Le panier est vide !";
                        }
                    ?>
                </div>
            </div>
        </div>
    </main>
    
    <?php require './view/partials/footer.html' ?>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="./ajax/cart-manager.js"></script>
</body>

</html>