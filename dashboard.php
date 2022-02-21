<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ./404.php');
}
require './class/admin-link.class.php';

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <?php require './view/partials/admin-head.html' ?>
    <title>Dashboard</title>
</head>

<body>
    <?php require './view/partials/admin-sidebar.html'; ?>

    <div class="content">
        <h1 class="text-center">Bienvenue sur le dashboard administrateur !</h1>
        <div class="container">
            <div class="row text-dark">
                <div class="col-md-6">
                    <a class="mx-auto txt-decoration" href="./customers-manager.php">
                        <div class="card mt-5 size-card">
                            <h1 class="text-center mt-2">Gestion des utilisateurs</h1>

                            <img id="size-img" src="./asset/ressources/images/icon/user-group.svg" />
                        </div>
                    </a>
                </div>

                <div class="col-md-6">
                    <a class="mx-auto txt-decoration " href="./admins-manager.php">
                        <div class="card mt-5 size-card">
                            <h1 class="text-center mt-2">Gestion des admins</h1>

                            <img id="size-img" src="./asset/ressources/images/icon/admin-with-cogwheels.svg" />
                        </div>
                    </a>
                </div>
            </div>
            <div class="row text-dark">
                <div class="col-md-6">
                    <a class="mx-auto txt-decoration " href="./orders-manager.php">
                        <div class="card mt-5 size-card">
                            <h1 class="text-center mt-2">Gestion des commandes</h1>
                            <img id="size-img" src="./asset/ressources/images/icon/delivery-box.svg" />
                        </div>
                    </a>
                </div>

                <div class="col-md-6">
                    <div data-bs-toggle="modal" data-bs-target="#exampleModal" class="card mt-5 size-card">
                        <h1 class="text-center mt-2">Se déconnecter</h1>

                        <img id="size-img" src="./asset/ressources/images/icon/se-deconnecter.svg" />
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <h1 class="text-dark text-center mb-5">Voulez-vous vous déconnecter ?</h1>
                        <div class="d-flex bd-highlight mb-3 text-dark">

                            <a style="width:200px" class="me-auto p-2 bd-highlight btn btn-primary"
                                data-bs-dismiss="modal">Non</a>
                            <a style="width:200px" class="p-2 bd-highlight btn btn-secondary"
                                href="./logout.php">Oui</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>



<!-- JavaScript Bundle with Popper -->
<script src=" https://code.jquery.com/jquery-3.6.0.min.js">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js">
</script>
</body>

</html>