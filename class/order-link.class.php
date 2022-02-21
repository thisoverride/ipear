<?php
	error_reporting(E_ALL);
	ini_set('display_errors', TRUE);
	ini_set('display_startup_errors', TRUE);
	
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

	require_once './class/db-link.class.php';
	
	class order_link extends db_link{

		public function get_all_orders(){
			//We surround order with backquotes because it's some SQL term
			return $this->db_get("`order`",["id","DESC"]);
		}

		public function get_orders_from_customer_id($id){
			return $this->db_getBy_All("`order`","customer_id",$id);
		}

		public function get_order_lines_from_id($id){
			$order = $this->db_getBy_One("`order`","id",$id);
			$order_lines = $this->db_getBy_All("order_line","order_id",$id);
			$order['lines'] = $order_lines;
			return $order;
		}

		public function change_order_state_from_id($id,$state) {
			$this->db_edit("order",["state"=>$state],$id,"id");
		}

		public function insert_order($cart) {
			if (isset($_SESSION['customer'])) {
				$datas_order = array();
				$datas_order["customer_id"] = $_SESSION['customer']['id'];
				$datas_order["state"] = "Nouvelle";
				$datas_order["date"] = date('Y-m-d');
				$datas_order["total_price"] = $cart->get_cart_total_price();
				$insertId = $this->db_add("order",$datas_order);
				$cart_content = $cart->get_cart_content();
				foreach ($cart_content as $product_line) {
					$datas_line = array();
					$datas_line["order_id"] = $insertId;
					$datas_line["product_id"] = $product_line['id'];
					$datas_line["quantity"] = $product_line['quantity'];
					$datas_line["total_price"] = $product_line['total_price'];
					$this->db_add("order_line",$datas_line);
				}
			}
		}
	}
?>