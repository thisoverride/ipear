<?php
	error_reporting(E_ALL);
	ini_set('display_errors', TRUE);
	ini_set('display_startup_errors', TRUE);
	class db_link{
		private $bdd=NULL;
		private $prepare = NULL;
		private $rowCount = 0;
		private $res = NULL;
		private $host;
		private $db_user;
		private $pass;
		private $dbname;
		private $port;
		private $charset;

		function __construct() {
			$this->check_env();
			$this->connect();
		}

		private function check_env() {
			// Using require so we don't generate fatal errors if file doesn't exist
			include './.env.php';
			$this->host = isset($_ENV['db_host']) ? $_ENV['db_host'] : "localhost";
			$this->db_user = isset($_ENV['db_user']) ? $_ENV['db_user'] : "defaultUser";
			$this->pass = isset($_ENV['db_pass']) ? $_ENV['db_pass'] : "defaultPass";
			$this->dbname = isset($_ENV['db_name']) ? $_ENV['db_name'] : "defaultDB";
			$this->port = isset($_ENV['db_port']) ? $_ENV['db_port'] : "3306";
			$this->charset = isset($_ENV['db_charset']) ? $_ENV['db_charset'] : "utf8";
		}

		private function connect() {
			$dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname . ';charset=' . $this->charset . ';port=' . $this->port;
			try {
				$bdd = new PDO ($dsn, $this->db_user, $this->pass);
				$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
			} catch(PDOException $e) {
				echo "<br>dsn : $dsn";
				die('Erreur : ' . $e->getMessage());
			}
			$this->bdd = $bdd;
		}

		private function execute_query($sql, $datas = NULL ) {
			try {
				$this->prepare = $this->bdd->prepare($sql);
				$this->res = $this->prepare->execute($datas);
				$this->rowCount = $this->prepare->rowCount();
			} catch(Exception $e) {
				echo "<br><b>Erreur ! " . $e->getMessage() . "</b>" . PHP_EOL;
				echo "<pre> La requete :" . $sql . "</pre>" . PHP_EOL;
				echo " <pre>Les datas : " . PHP_EOL;
				print_r($datas);
				echo "</pre>" . PHP_EOL;
			}
		}

		public function get_all($sql, $datas = NULL) {
			try {
				$this->execute_query($sql, $datas);
				return $this->prepare->fetchAll();
			} catch(Exception $e) {
				echo "Erreur " . $e->getMessage();
				echo "<br> SQL :" . $sql;
				echo "<br> datas :" . print_r($datas, true);
			}
		}

		public function get_one($sql, $datas = NULL) {
			try {
				$this->execute_query($sql, $datas);
				return $this->prepare->fetch();
			} catch(Exception $e) {
				echo "Erreur " . $e->getMessage();
				echo "<br> SQL :" . $sql;
				echo "<br> datas :" . print_r($datas, true);
			}
		}

		public function insert($sql, $datas = NULL, $return_id = TRUE) {
			try {
				$this->execute_query($sql, $datas);
				return $return_id ? $this->bdd->lastInsertId() : $this->res;
			} catch(Exception $e) {
				echo "Erreur " . $e->getMessage();
				echo "<br> SQL :" . $sql;
				echo "<br> datas :" . print_r($datas, true);
			}
		}

		public function exec($sql, $datas = NULL) {
			try {
				$this->execute_query($sql, $datas);
				return array('$this->tbl' => $this->res, 'rowCount' => $this->rowCount);
			} catch(Exception $e) {
				echo "Erreur " . $e->getMessage();
				echo "<br> SQL :" . $sql;
				echo "<br> datas :" . print_r($datas, true);
			}
		}

		public function show_tables() {
			$sql = "SHOW TABLES;";
			return $this->get_all($sql);
		}

		public function show_columns($table_name) {
			$sql = "SHOW COLUMNS FROM `$table_name`";
			return $this->get_all($sql);
		}

		public function lock_table($tbl) {
			// lock table to prevent other sessions from modifying the data and thus preserving data integrity
			$sql = 'LOCK TABLE `' . $tbl . '` WRITE';
			$this->exec($sql);
		}

		public function unlock_tables() {
			// unlock table 
			$sql = 'UNLOCK TABLES';
			$this->exec($sql);
		}

		public function db_add($tbl, $arrDatas = array(), $return_id = true) {
			$associative_name_value = array();
			$tmp = array();

			foreach ($arrDatas as $K => $V) {
				$associative_name_value[':' . $K] = $V;
				$tmp[] = $K;
			}

			$columns = join('`,`', $tmp);
			$named_fields = join(',:', $tmp);

			$sql = "INSERT INTO `" . $tbl . "`
					(`" . $columns . "`)
					VALUES (:" . $named_fields . ")";
			$datas = $associative_name_value;

			return $this->insert($sql, $datas, $return_id);
		}

		public function db_edit($tbl, $arrDatas = array(), $whereValue = 0, $whereField = 'id') {
			$associative_name_value = array();
			$tmp = array();

			foreach ($arrDatas as $K => $V) {
				$associative_name_value[':' . $K] = $V;
				$tmp[] = $K . '=:' . $K;
			}

			$fieldsValues = join(',', $tmp);

			$sql = "UPDATE `" . $tbl . "`
					SET $fieldsValues
					WHERE " . $whereField . " = '" . $whereValue . "'";
			$datas = $associative_name_value;

			//return array($sql, $datas);
			return $this->exec($sql, $datas);
		}

		public function db_remove($tbl, $whereValue = 0, $whereField = 'id') {
			$sql = "DELETE FROM " . $tbl . "
					WHERE " . $whereField . " = :" . $whereField;
			$datas = array(':' . $whereField => $whereValue);

			return $this->exec($sql, $datas);
		}

		public function db_get($tbl, $orderBy = array(), $arrlimit = array()) {
			$orderField = !empty($orderBy[0]) ? $orderBy[0] : 'id';
			$order = !empty($orderBy[1]) ? $orderBy[1] : 'ASC';
			$limit = !empty($arrlimit[0]) ? $arrlimit[0] : '';
			$offset = !empty($arrlimit[1]) ? $arrlimit[1] : '';

			$sql = "SELECT * FROM $tbl ORDER BY  $orderField $order $limit $offset";

			return $this->get_all($sql);
		}

		public function db_getBy_One($tbl, $field = 'id', $value = '', $orderBy = array(), $arrlimit = array()) {
			$strOrder = "";
			if (!empty($orderBy)) {
				$orderField = !empty($orderBy[0]) ? $orderBy[0] : 'id';
				$order = !empty($orderBy[1]) ? $orderBy[1] : 'ASC';
				$strOrder = "ORDER BY $orderField $order ";
			}
			$limit = !empty($arrlimit[0]) ? $arrlimit[0] : '';
			$offset = !empty($arrlimit[1]) ? $arrlimit[1] : '';

			$sql = "SELECT *
					FROM $tbl
					WHERE $field = :value
					$strOrder $limit $offset";

			$datas = array(':value' => $value);
			return $this->get_one($sql, $datas);
		}

		public function db_getBy_All($tbl, $field = 'id', $value = '', $orderBy = array(), $arrlimit = array()) {
			$strOrder = "";
			if (!empty($orderBy)) {
				$orderField = !empty($orderBy[0]) ? $orderBy[0] : 'id';
				$order = !empty($orderBy[1]) ? $orderBy[1] : 'ASC';
				$strOrder = "ORDER BY $orderField $order ";
			}
			$limit = !empty($arrlimit[0]) ? $arrlimit[0] : '';
			$offset = !empty($arrlimit[1]) ? $arrlimit[1] : '';

			$sql = "SELECT *
					FROM $tbl
					WHERE $field = :value
					$strOrder $limit $offset";

			$datas = array(':value' => $value);
			return $this->get_all($sql, $datas);
		}
	}
?>