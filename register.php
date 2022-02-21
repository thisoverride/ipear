<?php
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
    session_start();
    if (isset($_SESSION['customer']) || isset($_SESSION['admin'])) {
        header('Location: ./index.php');
    }
    require './class/customer-link.class.php';

    $last_name = isset($_POST['last_name']) ? trim($_POST['last_name']) : '';
    $first_name = isset($_POST['first_name']) ? trim($_POST['first_name']) : '';
    $birth_date = isset($_POST['birth_date']) ? trim($_POST['birth_date']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $phone_number = isset($_POST['phone_number']) ? trim($_POST['phone_number']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $password_confirm = isset($_POST['password_confirm']) ? $_POST['password_confirm'] : '';
    $address_input = isset($_POST['address_input']) ? trim($_POST['address_input']) : '';
    $address = isset($_POST['address']) ? trim($_POST['address']) : $address_input;
    $city = isset($_POST['city']) ? trim($_POST['city']) : NULL;
    $postal_code = isset($_POST['postal_code']) ? trim($_POST['postal_code']) : NULL;

    $error_message  =  "";


    if ((!empty($last_name) && !empty($first_name) && !empty($birth_date) && !empty($email)
        && !empty($phone_number) && !empty($password) && !empty($password_confirm) && !empty($address))) {
        $split_birth_date  =  explode("-",  $birth_date);
        $age  =  (date("md", date("U", mktime(0, 0, 0, $split_birth_date[2], $split_birth_date[1], $split_birth_date[0]))) > date("md"))
            ? ((date("Y") - $split_birth_date[0]) - 1)
            : (date("Y") - $split_birth_date[0]);
        if ($age > 18) {
            if ($password == $password_confirm) {
                $customer_link  =  new customer_link();
                if (!$customer_link->is_customer_email_used($email)) {
                    $options  =  [
                        'cost' => 10
                    ];
                    $password_hash = password_hash($password,  PASSWORD_DEFAULT,  $options);
                    $customer_link->insert_customer($last_name,  $first_name,  $birth_date,  $email,  $password_hash,  $phone_number,  $address,  $city,  $postal_code);
                    $customer_link->log_customer();
                    header('Location: ./index.php');
                } else {
                    $error_message  =  "L'adresse mail saisie correspond déjà à un compte !";
                }
            } else {
                $error_message  =  "Les deux mots de passe saisis ne sont pas identiques !";
            }
        } else {
            $error_message  =  "Vous devez être majeur pour créer votre Pear ID";
        }
    }
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" value="<?php echo $viewport ?>" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./asset/ressources/css/reset.css">
    <link rel="stylesheet" href="./asset/ressources/css/style.css">
    <title>Pear - Connexion</title>
</head>

<body>
    <?php require './view/partials/nav.php' ?>
    <main role="main">
        <div class="container">
            <div class="row row-pb">
                <div class="col-md-6 offset-md-6 mx-auto">
                    <form class="register-from" method="POST" action="">
                        <div class="mb-3 text-center">
                            <h1 class="mb-5">Créer votre identifiant Pear</h1>
                            <?php
                            if (!empty($error_message)) {
                                echo
                                '<div class="alert alert-danger" role="alert">'
                                    .  $error_message  .
                                    '</div>';
                            }
                            ?>
                            <input type="text" class="form-control" name="last_name" value="<?php echo $last_name ?>" placeholder="Nom" required>
                        </div>
                        <div class="mb-3 text-center">
                            <input type="text" class="form-control" name="first_name" value="<?php echo $first_name ?>" placeholder="Prénom" required>
                        </div>
                        <div class="mb-3 text-center">
                            <input type="date" class="form-control" name="birth_date" value="<?php echo $birth_date ?>" placeholder="Date de naissance" required>
                        </div>
                        <div class="mb-3 text-center">
                            <input type="email" class="form-control" name="email" value="<?php echo $email ?>" placeholder="Adresse mail" required>
                        </div>
                        <div class="mb-3 text-center">

                            <input type="tel" id="isNumber" class="form-control" name="phone_number" value="<?php echo $phone_number ?>" placeholder="Numéro de téléphone" required>
                        </div>

                        <div class="mb-3 text-center">

                            <input type="password" id="password" class="form-control" name="password" value="<?php echo $password ?>" placeholder="Mot de passe" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" id="password_confirm" class="form-control" name="password_confirm" value="<?php echo $password_confirm ?>" placeholder="Confirmation du mot de passe" required>
                            <span class="ml-auto" id="message"></span>
                        </div>

                        <div class="mb-5 text-center">
                            <input type="text" class="form-control isAddress" value="<?php echo $address_input ?>" autocomplete="off" placeholder="22 rue saint-augustin paris 75002" required>
                            
                        </div>
                        <div class="hiddenAddress">
                            <input type="text" name="address" id="address" value="<?php echo $address ?>">
                            <input type="text" name="city" id="city" value="<?php echo $city ?>">
                            <input type="text" name="postal_code" id="postal_code" value="<?php echo $postal_code ?>">
                        </div>
                        <button type="submit" id="from-submit" class="btn btn-primary d-block mx-auto">Continuer</button>
                    </form>
                    <a class="text-center d-block mt-4" href="login.php">Vous avez déja un identifiant Pear ?
                        Connectez-vous</a>
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
</body>

</html>