<?php
	session_start();
	require './class/product-link.class.php';
	$product_link = new product_link();
	$id =  isset($_POST['id']) ? $_POST['id'] : NULL;
	if (isset($_POST['delete-product'])) {
		$product_link->delete_product($id);
	} else if ( isset($_POST['modify-product']) ) {
		$product = $product_link->get_product_from_id($id);
		$modified_non_empty_values = [];
		foreach ($_POST as $k => $v) {
			if (isset($v) && $v != '' && $v != NULL && (isset($product[$k]) || empty($product[$k])) && $v != $product[$k] ) {
				$modified_non_empty_values[$k] = $v;
			}
		}
		$product_link->update_product($id,$modified_non_empty_values);
	}
	header('Location: ./products-manager.php');
?>