<?php
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if(isset($_SESSION['customer']) || isset($_SESSION['admin'])){
        $login_logout_section='<hr class="dropdown-divider"><li><a class="dropdown-item" href="logout.php">Se déconnecter</a></li>';
    }else{
        $login_logout_section='<hr class="dropdown-divider"><li><a class="dropdown-item" href="login.php">Se connecter</a></li>';
    }
    if(isset($_SESSION['customer'])) {
        $cart_section = '<li><a class="dropdown-item" href="cart.php">Panier</a></li>';
        $profile_section = '<hr class="dropdown-divider"><li><a class="dropdown-item" href="profile.php">Profil</a></li>';
        $command_section = '<hr class="dropdown-divider"><li><a class="dropdown-item" href="orders.php">Commandes</a></li>';
    } else if (isset($_SESSION['admin'])) {
        $cart_section = '';
        $profile_section = '<li><a class="dropdown-item" href="dashboard.php">Dashboard</a></li>';
        $command_section = '';
    } else {
        $cart_section = '<li><a class="dropdown-item" href="login.php">Panier</a></li>';
        $profile_section = '';
        $command_section = '';
    }
?>
<nav class="navbar navbar-expand-lg bg-shadow fixed-top">
    <div class="container">

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand text-center pr-5 mx-auto" id="logo" href="index.php"></a>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 mx-auto">
                <li class="nav-item">
                    <a class="nav-link" href="product-stack.php?category_id=1">iPear</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="product-stack.php?category_id=2">iPed</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="product-stack.php?category_id=3">iWotch</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Assistance</a>
                </li>
            </ul>
        </div>
        <div class="btn-group">
            <button type="button" class="" id="bag" data-bs-toggle="dropdown" aria-expanded="false">

            </button>
            <ul class="dropdown-menu mt-3">
                <?php echo $cart_section ?>
                <?php echo $profile_section ?>
                <?php echo $command_section ?>
                <?php echo $login_logout_section ?>
            </ul>
        </div>
    </div>
</nav>