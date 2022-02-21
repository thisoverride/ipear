<?php
    error_reporting(E_ALL);
    session_start();
    if (!isset($_SESSION['admin'])) {
        header('Location: ./404.php');
    }
    require './class/admin-link.class.php';
    require  './admin-template.php';
    $admin_link  =  new admin_link();
    $login = isset($_POST['login']) ? trim($_POST['login']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    if (!empty($login) && !empty($password) && !empty($email)) {
        if (!$admin_link->is_admin_login_used($email) && !$admin_link->is_admin_login_used($login)) {
            $options  =  ['cost' => 10];
            $password_hash = password_hash($password,  PASSWORD_DEFAULT,  $options);
            $admin_link->insert_admin($login, $email, $password_hash);
            header('Location: ./admins-manager.php');
        }
    }
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <?php require './view/partials/admin-head.html' ?>
    <title>Dashboard | Gestion des administrateurs</title>
</head>

<body>
    <?php require './view/partials/admin-sidebar.html' ?>
    <div class="content">
        <h1 class="text-center">Gestion des administrateurs</h1>
        <div class="container">
            <div class="row">
                <div class="col-md-7 offest-md-5 mx-auto card mt-5">
                    <button class="option_btn mx-auto" data-bs-toggle="modal" data-bs-target="#add-admin">+</button>
                    <?php
                    $admins = $admin_link->get_all_admins();
                    echo_admin_table($admins);
                    ?>
                </div>
            </div>
        </div>
        <!-- Add administrator in database -->
        <div class="modal fade" id="add-admin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <h1 class="text-dark text-center mt-4 mb-2">Ajout d'un administrateur</h1>
                        <form class="register-from" method="POST" action="">

                            <input type="text" class="form-control mb-3" name="login" placeholder="Login" require>

                            <input type="email" class="form-control mb-3" name="email" placeholder="Email" require>
                            <input type="password" class="form-control mb-3" name="password" placeholder="Mot de passe"
                                require>
                            <button type="submit" class="btn btn-primary d-block mx-auto">Ajouter</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Bundle with Popper -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>