<?php
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);

	chdir("..");
	require_once './class/order-link.class.php';

	$id = isset($_GET['id']) ? $_GET['id'] : NULL;
	$state = isset($_GET['state']) ? $_GET['state'] : 'Nouvelle';
	
    $order_link = new order_link();
	$order_link->change_order_state_from_id($id,$state);

?>