<?php
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);

	chdir("..");
	require_once './class/cart.class.php';

	$id = isset($_GET['id']) ? $_GET['id'] : NULL;
	
	$cart = new cart();
	$cart->remove_product($id);

	echo $cart->get_cart_total_price();
?>