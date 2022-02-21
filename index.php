<?php
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon" sizes="57x57" href="./asset/ressources/images/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="./asset/ressources/images/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="./asset/ressources/images/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="./asset/ressources/images/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="./asset/ressources/images/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="./asset/ressources/images/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="./asset/ressources/images/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="./asset/ressources/images/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="./asset/ressources/images/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="./asset/ressources/images/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./asset/ressources/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="./asset/ressources/images/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./asset/ressources/images/favicon/favicon-16x16.png">


    <link rel="manifest" href="./asset/ressources/images/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./asset/ressources/css/reset.css">
    <link rel="stylesheet" href="./asset/ressources/css/style.css">
    <title>Pear</title>
</head>

<body>
    <?php require './view/partials/nav.php' ?>
    <main role="main">
        <div class="container-fluid">
            <div class="row">
                <div class="wrapper-header">
                    <h2 role="presentation">Réalisé avec l’iPear</h2>
                    <h3 role="presentation">« Le Peintre », un film de J.B. Braud.</h3>
                    <a href="https://www.youtube.com/watch?v=Gvf9pgUEZ7s" target="_blank">Découvrir ></a>
                </div>
                <section role="">
                    <div class="wrapper-section">
                        <h2>iPear 12</h2>
                        <h3 role="presentation">Vers la vitesse et au‑delà.</h3>
                        <p>À partir de 809 € avant reprise de votre appareil.</p>
                        <a href="./product.php?product_id=4">Acheter ></a>
                    </div>
                    <div class="wrp-bg"></div>
                </section>
            </div>

            <section>
                <div class="row">
                    <div class="wrapper-section-pro">
                        <h2>iPear 12 Pro</h2>
                        <h3 role="presentation">On n’arrête pas le progrès. On l’accélère.</h3>
                        <p>À partir de 1 159 € avant reprise de votre appareil.</p>
                        <a href="./product.php?product_id=5">Acheter > </a>
                        <div class="row">
                            <div class="wrp-pro"></div>

                        </div>
                    </div>
                </div>
            </section>


            <section>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="air-presentation">
                            <h2>iPed Air</h2>
                            <h3 class="mb-2 mt-1" role="presentation">Le plein de matière grise Et de couleurs.</h3>
                            <a href="./product.php?product_id=6">Acheter ></a>
                        </div>
                        <div class="wrp-air"></div>
                    </div>
                    <div class="col-lg-6">
                        <div class="watch-presentation">
                            <h2><span id="tilte-watch"></span>iWotch</h2>
                            <h3 class="mb-2 mt-1" role="presentation">Series 6</h3>
                            <a href="./product.php?product_id=10">Acheter ></a>
                        </div>
                        <div class="wrp-watch"></div>
                    </div>
                </div>
        </div>

        </section>
        </div>
    </main>
    <?php require './view/partials/footer.html' ?>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
