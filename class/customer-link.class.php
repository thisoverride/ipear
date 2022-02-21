<?php
	error_reporting(E_ALL);
	ini_set('display_errors', TRUE);
	ini_set('display_startup_errors', TRUE);
	require_once './class/db-link.class.php';
	class customer_link extends db_link{
		private $customer=NULL;

		public function is_customer_email_used($email){
			$this->customer = $this->db_getBy_One("customer","email",$email);
			return $this->customer != null;
		}

		public function check_customer_credentials($email,$password){
			return $this->is_customer_email_used($email) ? password_verify($password,$this->customer['password']) : FALSE;
		}

		public function get_customer_from_id($id) {
			return $this->db_getBy_One("customer","id",$id);
		}

		public function get_all_customers() {
			return $this->db_get("customer");
		}

		public function log_customer_from_id($id) {
			$this->customer = $this->get_customer_from_id($id);
			$this->log_customer();
		}

		public function log_customer() {
			$_SESSION["customer"]["id"] = $this->customer["id"];
			$_SESSION["customer"]["last_name"] = $this->customer["last_name"];
			$_SESSION["customer"]["first_name"] = $this->customer["first_name"];
			$_SESSION["customer"]["birth_date"] = $this->customer["birth_date"];
			$_SESSION["customer"]["email"] = $this->customer["email"];
			$_SESSION["customer"]["password"] = $this->customer["password"];
			$_SESSION["customer"]["phone_number"] = $this->customer["phone_number"];
			$_SESSION["customer"]["address"] = $this->customer["address"];
			$_SESSION["customer"]["city"] = $this->customer["city"];
			$_SESSION["customer"]["postal_code"] = $this->customer["postal_code"];
			$_SESSION["customer"]["creation_date"] = $this->customer["creation_date"];
		}

		public function insert_customer($last_name,$first_name,$birth_date,$email,$password_hash,$phone_number,$address,$city,$postal_code){
			$datas = array();
			$datas["last_name"] = $last_name;
			$datas["first_name"] = $first_name;
			$datas["birth_date"] = $birth_date;
			$datas["email"] = $email;
			$datas["password"] = $password_hash;
			$datas["phone_number"] = $phone_number;
			$datas["address"] = $address;
			$datas["city"] = $city;
			$datas["postal_code"] = $postal_code;
			$datas["creation_date"] = date('Y-m-d');
			$insertId = $this->db_add("customer",$datas);
			$this->customer = $this->get_customer_from_id($insertId);
		}

		public function update_customer($id,$datas) {
			$this->db_edit("customer",$datas,$id,"id");
		}

		public function delete_customer($id) {
			$this->db_remove("customer",$id,"id");
		}
	}
?>