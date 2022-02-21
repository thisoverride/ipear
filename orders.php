<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['customer'])) {
    header('Location: ./index.php');
}
require './class/order-link.class.php';
require './order-template.php';

$customer_id = isset($_SESSION['customer']['id']) ? $_SESSION['customer']['id'] : NULL;
$order_link = new order_link();
$customer_orders = $order_link->get_orders_from_customer_id($customer_id);

?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./asset/ressources/css/reset.css">
    <link rel="stylesheet" href="./asset/ressources/css/style.css">
    <title>Vos commandes</title>
</head>

<body>
    <?php require './view/partials/nav.php' ?>
    <main role="main">
        <div class="container">
            <div class="row row-pb">
                <div class="col-lg-12 mx-auto mt-5 pt-5">
                    <?php
                    foreach ($customer_orders as $order) {
                        echo_single_order($order);
                    }
                    ?>
                </div>
            </div>
        </div>
    </main>

    <?php require './view/partials/footer.html' ?>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
    <script></script>
</body>

</html>