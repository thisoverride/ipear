<?php
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
    session_start();
    if (!isset($_SESSION['admin'])) {
        header('Location: ./404.php');
    }
    require  './customer-template.php';
    require './class/customer-link.class.php';

    $customer_link  =  new customer_link();
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <?php require './view/partials/admin-head.html' ?>
    <title>Dashboard | Gestion des utilisateurs</title>
</head>

<body>
    <?php require './view/partials/admin-sidebar.html' ?>

    <div class="content">
        <h1 class="text-center">Gestion des utilisateurs</h1>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 mx-auto card mt-5 p-2">
                    <?php
                        $customers = $customer_link->get_all_customers();
                        echo_customers_table($customers);
                    ?>
                </div>

            </div>
        </div>
    </div>

    <!-- JavaScript Bundle with Popper -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./asset/ressources/js/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./asset/ressources/js/customer-fields-controls.js"></script>
    
</body>

</html>