<?php
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
    session_start();
    if (!isset($_SESSION['customer'])) {
        header('Location: ./index.php');
    } 
    require './class/customer-link.class.php';
    require './customer-template.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./asset/ressources/css/reset.css">
    <link rel="stylesheet" href="./asset/ressources/css/style.css">
    <title>Votre profil</title>
</head>

<body>
    <?php require './view/partials/nav.php' ?>
    <main id="profil" role="main">
        <div class="container">
            <div class="row row-pb">
                <h1 class="text-center mt-5">Mes informations</h1>
                <div class="col-lg-12 mx-auto mt-5 pt-5">
                    <?php
						echo_customers_table([$_SESSION["customer"]]);
					?>
                </div>
            </div>
        </div>
    </main>

    <?php require './view/partials/footer.html' ?>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="./asset/ressources/js/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
    <script src="./asset/ressources/js/customer-fields-controls.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
    <script></script>
</body>

</html>