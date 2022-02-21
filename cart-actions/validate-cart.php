<?php
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);

	chdir("..");
	require_once './class/cart.class.php';
    require_once './class/order-link.class.php';
	
	$cart = new cart();
    $order_link = new order_link();

    $order_link->insert_order($cart);
    $cart->cleanup_cart();
?>