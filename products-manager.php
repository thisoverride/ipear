<?php
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['admin'])) {
        header('Location: ./index.php');
    }
    require './class/product-link.class.php';
    require './product-template.php';

    $product_link = new product_link();
    $all_products = $product_link->get_all_products();

    $category_id = isset($_POST['category_id']) ? trim($_POST['category_id']) : '';
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';
    $price = isset($_POST['price']) ? trim($_POST['price']) : '';
    $stock = isset($_POST['stock']) ? trim($_POST['stock']) : '';
    $picture = isset($_POST['picture']) ? trim($_POST['picture']) : '';

    if (!empty($category_id) && !empty($name) && !empty($description) && !empty($price) && !empty($stock) && !empty($picture)) {
        if (!$product_link->is_product_name_used($name)) {
            $product_link->insert_product($category_id,$name,$description,$price,$picture,$stock);
            header('Location: ./products-manager.php');
        }
    }

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <?php require './view/partials/admin-head.html' ?>
    <title>Dashboard | Gestion des produits</title>
</head>

<body>
    <?php require './view/partials/admin-sidebar.html' ?>
    <div class="content container">
        <h1 class="text-center">Liste des produits</h1>
        <div class="row">
            <div class="col-md-12 text-center pt-4">
                <button class="option_btn mx-auto text-center" data-bs-toggle="modal" data-bs-target="#exampleModal">+</button>
                <div class="col-md-12 card p-2 mx-auto">
                    <?php
                        echo_products_table($all_products);
                    ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                        <h1 class="text-dark text-center mt-4 mb-2">Ajout d'un produit</h1>
                        <form class="register-from" method="POST" action="">
                            <select name="category_id" id="category_id" class="form-select mb-3">
                                <option value="1" selected>iPear</option>
                                <option value="2">iPed</option>
                                <option value="3">iWotch</option>
                            </select>
                            <input name="name" class="form-control mb-3" type="text" id="name" placeholder="Nom du produit" require>
                            <input name="description" class="form-control mb-3" type="text" id="description" placeholder="Description" require>
                            <input name="price" class="form-control mb-3" id="price" placeholder="Prix" require>
                            <input name="stock" class="form-control mb-3" type="text" id="stock" placeholder="Stock" require>
                            <input name="picture" class="form-control mb-3" type="text" id="picture" placeholder="Emplacement photo" require>
                            <button type="submit" class="btn btn-primary d-block mx-auto">Ajouter</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./ajax/product-manager.js"></script>
</body>

</html>