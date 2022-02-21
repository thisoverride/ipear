<?php
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
    session_start();
    if(isset($_SESSION['customer']) || isset($_SESSION['admin'])){
        header('Location: ./index.php');
    }
    require './class/customer-link.class.php';
    
	$email = isset($_POST['email']) ? trim($_POST['email']) : '';
	$password = isset($_POST['password']) ? $_POST['password'] : '';

    $error_message="";

    if(!empty($email) && !empty($password)){
        $customer_link = new customer_link();
        if($customer_link->is_customer_email_used($email)){
            if($customer_link->check_customer_credentials($email,$password)){
                $customer_link->log_customer();
                header('Location: ./index.php');
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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./asset/ressources/css/reset.css">
    <link rel="stylesheet" href="./asset/ressources/css/style.css">
    <title>Connexion...</title>
</head>

<body>
    <?php require './view/partials/nav.php' ?>
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
                            <input type="email" name="email" class="form-control" placeholder="Pear ID"
                                value="<?php echo $email ?>" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" name="password" class="form-control" placeholder="Mot de passe"
                                required>
                            <em class="d-block text-center mt-3">Votre identifiant Pear est l’adresse e-mail que vous
                                utilisez
                                <br>pour vous connecter à iPearTune, à l’Pear Store et à iCloud.</em>
                        </div>
                        <button type="submit" class="btn btn-primary d-block mx-auto">Connexion</button>
                    </form>
                    <a class="text-center d-block mt-4 mb-5 " href="register.php">Vous n’avez pas d’identifiant Pear ?
                        Créez-en
                        <br> un maintenant.</a>
                </div>
            </div>
        </div>
    </main>

    <?php require './view/partials/footer.html' ?>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>