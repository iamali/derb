<?php
	class Derb {

		private $connection;
		private $stmt;
		private $querystring;
		private $error;

		private $host = DB_HOST;
		private $dbname = DB_NAME;
		private $username = DB_USER;
		private $password = DB_PASS;

		public function __construct() {
			$db = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
			$options = array( PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION );

			try {
			    $this->connection = new PDO($db, $this->username, $this->password, $options);
			} catch (PDOException $e) {
			    $this->error = $e->getMessage();
			}
		}

		public function execute() {
			$this->stmt = $this->connection->prepare($this->querystring);
			if (func_num_args() > 0) {
				$args = func_get_arg(0);
				$this->stmt->execute($args);
			} else {
				$this->stmt->execute();
			}
			$this->querystring = "";
		}

		// get all results
		public function getResults() {
		    return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
		}

		// get single result
		public function getResult() {
		    return $this->stmt->fetch(PDO::FETCH_ASSOC);
		}

		// get number of rows
		public function rowCount() {
		    return $this->stmt->rowCount();
		}

		// get id of last inserted item
		public function lastInsertId() {
		    return $this->connection->lastInsertId();
		}

		// output the query
		public function showQuery() {
			echo "<pre>" . $this->querystring . "</pre>";
		}

		public function custom() {
			$args = func_get_args();
			$this->querystring .= $args[0];
		}


/*-------------------------------------------------------------
	SELECT 
-------------------------------------------------------------*/
		// select
		public function select() {
			$args = func_get_args();
			$argslength = count($args);
			$i = 0;

			$this->querystring .= "SELECT ";
			foreach ($args as $value) {
				$this->querystring .= $value;
				$this->querystring .= ($i != $argslength - 1 ? ", " : "");
				$i++;
			}
		}

		// from
		public function from() {
			$args = func_get_args();
			$this->querystring .= " FROM " . $args[0];
		}

		// join
		public function join() {
			$args = func_get_args();
			$this->querystring .= " INNER JOIN " . $args[0] . " ON " . $args[1];
		}

		public function where() {
			$args = func_get_args();
			$this->querystring .= " WHERE " . $args[0];
		}

		public function orderby() {
			$args = func_get_args();
			$this->querystring .= " ORDER BY " . $args[0];
		}


/*-------------------------------------------------------------
	INSERT 
-------------------------------------------------------------*/
		// insert
		public function insert() {
			$args = func_get_args();
			$this->querystring .= "INSERT INTO " . $args[0] . " ";
		}

		// fields
		public function fields() {
			$args = func_get_args();
			$argslength = count($args);

			$i = 0;
			$this->querystring .= " (";
			foreach ($args as $value) {
				$this->querystring .= $value;
				$this->querystring .= ($i != $argslength - 1 ? ", " : "");
				$i++;
			}
			$this->querystring .= ")";

			$i = 0;
			$this->querystring .= " VALUES (";
			foreach ($args as $value) {
				$this->querystring .= ":" . $value;
				$this->querystring .= ($i != $argslength - 1 ? ", " : "");
				$i++;
			}
			$this->querystring .= ")";
		}


/*-------------------------------------------------------------
	DELETE 
-------------------------------------------------------------*/
		// delete
		public function delete() {
			$args = func_get_args();
			$this->querystring .= "DELETE FROM " . $args[0];
		}


/*-------------------------------------------------------------
	UPDATE
-------------------------------------------------------------*/
		// update
		public function update() {
			$args = func_get_args();
			$this->querystring .= "UPDATE " . $args[0] . " SET ";

		}

		// fields
		public function set() {
			$args = func_get_args();
			$argslength = count($args);

			$i = 0;
			foreach ($args as $value) {
				$this->querystring .= $value . " = ?";
				$this->querystring .= ($i != $argslength - 1 ? ", " : "");
				$i++;
			}
		}
	}
?>
