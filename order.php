<?php
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!(isset($_SESSION['customer']) || isset($_SESSION['admin'])) ) {
        header('Location: ./index.php');
    } 

    require './class/order-link.class.php';
    require './order-template.php';

    $order_link = new order_link();
    $id = isset($_GET['id']) ? $_GET['id'] : NULL;
    $order = $order_link->get_order_lines_from_id($id);
    $customer_id = isset($_SESSION['customer']['id']) ? $_SESSION['customer']['id'] : NULL;
    $is_authorized = ($customer_id == $order['customer_id']) || isset($_SESSION['admin']);
    
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <?php 
        require './view/partials/head.html';
        if (isset($_SESSION['admin'])) {
            echo '<link rel="stylesheet" href="./asset/ressources/css/admin.css">';
        }
    ?>
    <title>Votre profil</title>
</head>

<body>
    <?php 
        if (isset($_SESSION['customer'])) {
            require './view/partials/nav.php';
        } else if (isset($_SESSION['admin'])) {
            require './view/partials/admin-sidebar.html';
        }
    ?>

    <div class="content container">
        <div class="row row-pb">
            <div class="col-lg-12 mx-auto">
                <?php
                        if ($is_authorized) {
                            echo_full_order($order);
                        }
					?>
            </div>
        </div>
    </div>

    <?php 
        if (isset($_SESSION['customer'])) {
            require './view/partials/footer.html';
        }
    ?>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="./ajax/order-manager.js"></script>
</body>

</html>