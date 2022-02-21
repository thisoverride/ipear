<?php
	error_reporting(E_ALL);
	ini_set('display_errors', TRUE);
	ini_set('display_startup_errors', TRUE);

	require_once './class/db-link.class.php';
	
	class product_link extends db_link{

		public function get_products_from_category($category_id){
			return $this->db_getBy_All("product","category_id",$category_id);
		}

		public function get_product_from_id($product_id){
			return $this->db_getBy_One("product","id",$product_id);
		}

		public function is_product_name_used($product_name){
			return $this->db_getBy_One("product","name",$product_name) != null;
		}

		public function get_all_products(){
			return $this->db_get("product");
		}
		
		public function insert_product($category_id,$name,$description,$price,$picture,$stock){
			$datas = array();
			$datas["category_id"] = $category_id;
			$datas["name"] = $name;
			$datas["description"] = $description;
			$datas["price"] = $price;
			$datas["picture"] = $picture;
			$datas["stock"] = $stock;
			$insertId = $this->db_add("product",$datas);
			$this->product = $this->get_product_from_id($insertId);
		}
		
		public function update_product($id,$datas) {
			$this->db_edit("product",$datas,$id,"id");
		}

		public function delete_product($id) {
			$this->db_remove("product",$id,"id");
		}
	}
?>