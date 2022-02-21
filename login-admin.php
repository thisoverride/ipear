<?php
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
    session_start();
    if(isset($_SESSION['customer']) || isset($_SESSION['admin'])){
        header('Location: ./index.php');
    }
    require './class/admin-link.class.php';
    
	$login = isset($_POST['login']) ? trim($_POST['login']) : '';
	$password = isset($_POST['password']) ? $_POST['password'] : '';
    
    $error_message="";

    if(!empty($login) && !empty($password)){
        $admin_link = new admin_link();
        if($admin_link->is_admin_login_used($login)){
            if($admin_link->check_admin_credentials($login,$password)){
                $admin_link->log_admin();
                header('Location: ./dashboard.php');
            }else{
                $error_message="Mot de passe incorrect !";
            }
        }else{
            $error_message="Adresse mail inconnue !";
        }
    }
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include './view/partials/head.html' ?>
    <title>admin</title>
</head>

<body>

    <main role="main">
        <div class="container">
            <div class="row row-pb">
                <div class="col-lg-6 offset-lg-6 mx-auto">
                    <form class="login-from mb-5" method="POST" action="">
                        <div class="mb-3 text-center">
                            <h1 class="mb-5">Veuillez vous connecter.</h1>
                            <?php 
                            if(!empty($error_message)){
                                echo 
                                '<div class="alert alert-danger" role="alert">'
                                    .$error_message.
                                '</div>';
                            }
                            ?>
                            <input type="text" name="login" class="form-control" placeholder="Pear ID ou email"
                                value="<?php echo $login ?>" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" name="password" class="form-control" placeholder="Mot de passe"
                                required>
                        </div>
                        <button type="submit" class="btn btn-primary d-block mx-auto">Connexion</button>
                    </form>
                </div>
            </div>
        </div>
    </main>



    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>