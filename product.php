<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
session_start();
$product_id = isset($_GET['product_id']) ? $_GET['product_id'] : null;

require './class/product-link.class.php';

if (!empty($product_id)) {
    require './product-template.php';
    $product_link = new product_link();
    $product = $product_link->get_product_from_id($product_id);
}
?>

<!DOCTYPE html>
<html lang="fr">

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
    <main id="product-shopping" role="main">
        <div class="container pt-5">
            <?php single_product($product['id'], $product['name'], $product['description'], $product['price'], $product['picture']) ?>
        </div>
    </main>

    <?php require './view/partials/footer.html' ?>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="./ajax/cart-manager.js"></script>
</body>

</html>