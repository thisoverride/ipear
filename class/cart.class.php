<?php
	error_reporting(E_ALL);
	ini_set('display_errors', TRUE);
	ini_set('display_startup_errors', TRUE);
	class cart {
		
		function __construct() {
			if (session_status() == PHP_SESSION_NONE) {
				session_start();
			}
			$_SESSION['cart'] = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
		}
		
		function cleanup_cart() {
			unset($_SESSION['cart']);
		}

		function get_cart_content() {
			return isset($_SESSION['cart']) && !empty($_SESSION['cart']) ? $_SESSION['cart'] : NULL;
		}
		
		function get_cart_total_price() {
			$total_price = 0;
			foreach ($_SESSION['cart'] as  $product) {
				$total_price += $product['total_price'];
			}
			return $total_price;
		}

		function get_product($id) {
			return isset($_SESSION['cart'][$id]) && !empty($_SESSION['cart'][$id]) ? $_SESSION['cart'][$id] : NULL;
		}

		function get_product_total_price($id) {
			return isset($_SESSION['cart'][$id]['total_price']) && !empty($_SESSION['cart'][$id]['total_price']) ? $_SESSION['cart'][$id]['total_price'] : 0;
		}

		function add_product($id, $name, $quantity, $price) {
			if ($quantity > 0 && $price >= 0) {
				$_SESSION['cart'][$id]['id'] = $id;
				$_SESSION['cart'][$id]['name'] = $name;
				$_SESSION['cart'][$id]['price'] = $price;
				$_SESSION['cart'][$id]['quantity'] = isset($_SESSION['cart'][$id]['quantity']) ? $_SESSION['cart'][$id]['quantity'] + $quantity : $quantity;
				$_SESSION['cart'][$id]['total_price'] = isset($_SESSION['cart'][$id]['total_price']) ? $_SESSION['cart'][$id]['total_price'] + $quantity*$price : $quantity*$price;
			}
		}

		function remove_product($id) {
			unset($_SESSION['cart'][$id]);
		}

		function add_one_product($id) {
			if (isset($_SESSION['cart'][$id]) && !empty($_SESSION['cart'][$id])) {
				if (isset($_SESSION['cart'][$id]['quantity']) && $_SESSION['cart'][$id]['quantity'] < 999) {
					$_SESSION['cart'][$id]['quantity'] += 1;
				}
				if (isset($_SESSION['cart'][$id]['total_price'])) {
					$_SESSION['cart'][$id]['total_price'] += $_SESSION['cart'][$id]['price'];
				}
			}
		}

		function remove_one_product($id) {
			if (isset($_SESSION['cart'][$id]) && !empty($_SESSION['cart'][$id])) {
				if (isset($_SESSION['cart'][$id]['quantity']) && $_SESSION['cart'][$id]['quantity'] > 0) {
					$_SESSION['cart'][$id]['quantity'] -= 1;
				}
				if (isset($_SESSION['cart'][$id]['total_price'])) {
					$_SESSION['cart'][$id]['total_price'] -= $_SESSION['cart'][$id]['price'];
				}
			}
		}

		function change_product_quantity($id,$quantity) {
			if (isset($_SESSION['cart'][$id]) && !empty($_SESSION['cart'][$id])) {
				$_SESSION['cart'][$id]['id'] = $id;
				$_SESSION['cart'][$id]['quantity'] = $quantity;
				$_SESSION['cart'][$id]['total_price'] = $quantity*$_SESSION['cart'][$id]['price'];
			}
		}
	}
?>
