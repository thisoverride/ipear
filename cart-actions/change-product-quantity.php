<?php
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);

	chdir("..");
	require_once './class/cart.class.php';

	$id = isset($_GET['id']) ? $_GET['id'] : NULL;
	$quantity = isset($_GET['quantity']) ? $_GET['quantity'] : 1;
	
	$cart = new cart();
	$cart->change_product_quantity($id,$quantity);
	echo $cart->get_cart_total_price($id).','.$cart->get_product_total_price($id);

?>