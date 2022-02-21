<?php
	error_reporting(E_ALL);
	ini_set('display_errors', TRUE);
	ini_set('display_startup_errors', TRUE);
	require_once './class/db-link.class.php';
	class admin_link extends db_link{
		private $admin=NULL;

		public function is_admin_login_used($login){
			$this->admin = $this->db_getBy_One("admin","email",$login);
			if ($this->admin == null) {
				$this->admin = $this->db_getBy_One("admin","login",$login);
			}
			return $this->admin != null;
		}

		public function check_admin_credentials($login,$password){
			return $this->is_admin_login_used($login) ? password_verify($password,$this->admin['password']) : FALSE;
		}

		public function get_admin_from_id($id) {
			return $this->db_getBy_One("admin","id",$id);
		}
		
		public function get_all_admins() {
			return $this->db_get("admin");
		}

		public function log_admin_from_id($id) {
			$this->admin = $this->get_admin_from_id($id);
			$this->log_admin();
		}

		public function log_admin() {
			$_SESSION["admin"]["login"] = $this->admin["login"];
			$_SESSION["admin"]["email"] = $this->admin["email"];
			$_SESSION["admin"]["password"] = $this->admin["password_hash"];
		}

		public function insert_admin($login,$email,$password_hash){
			$datas = array();
			$datas["login"] = $login;
			$datas["email"] = $email;
			$datas["password"] = $password_hash;
			$insertId = $this->db_add("admin",$datas);
			$this->admin = $this->get_admin_from_id($insertId);
		}

		public function update_admin($id,$datas) {
			$this->db_edit("admin",$datas,$id,"id");
		}

		public function delete_admin($id) {
			$this->db_remove("admin",$id,"id");
		}
	}
?>