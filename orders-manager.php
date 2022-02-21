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
require './class/order-link.class.php';
require './order-template.php';

$order_link = new order_link();
$all_orders = $order_link->get_all_orders();

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <?php require './view/partials/admin-head.html' ?>
    <title>Dashboard | Gestion des commandes</title>
</head>

<body>
    <?php require './view/partials/admin-sidebar.html' ?>
    <div class="content text-dark">
        <div class=" container">
            <div class="row">
                <h1 class="text-center text-light mb-4">Liste des commandes</h1>
                <div class="col-md-12 card p-4">
                    <div class="col-md-12 mx-auto">
                        <?php
                        foreach ($all_orders as $order) {
                            echo_single_order($order);
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./ajax/order-manager.js"></script>
</body>

</html>