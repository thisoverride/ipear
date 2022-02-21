<?php
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);

	chdir("..");
	require_once './class/cart.class.php';
    require_once './class/product-link.class.php';

	$id = isset($_GET['id']) ? $_GET['id'] : NULL;
	$quantity = isset($_GET['quantity']) ? $_GET['quantity'] : 0;
	$product_link = new product_link();
	$product = $product_link->get_product_from_id($id);
	
	$cart = new cart();
	$cart->add_product($id,$product['name'],$quantity,$product['price']);

?>