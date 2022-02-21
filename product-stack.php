<?php
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
    session_start();
    $category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;

    require './class/product-link.class.php';

    if(!empty($category_id)){
        require './product-template.php';
        $product_link = new product_link();
        $products = $product_link->get_products_from_category($category_id);
    }
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
    <main id="product-main" role="main" class="bg-dark">
        <div class="container-fluid bg-dark col-md-10">
            <?php
            $odd=True;
            foreach ($products as $product){
                $odd ? odd_product($product['id'],$product['name'],$product['description'],$product['price'],$product['picture']) 
                    : even_product($product['id'],$product['name'],$product['description'],$product['price'],$product['picture']);
                $odd = !$odd;
            }
            ?>
        </div>
    </main>

    <?php require './view/partials/footer.html' ?>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>