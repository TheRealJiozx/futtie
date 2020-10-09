<?php
class DB {
	private $con;
	private $host = "localhost";
	private $dbname = "futtie";
	private $user = "root";
	private $password = "";
	
	public function __construct() {
		$dsn = "mysql:host=" .$this->host . ";dbname=" .
		$this->dbname;
		
		try {
			$this->con = new PDO($dsn, $this->user, $this->password);
			$this->con->setAttribute(PDO::ATTR_ERRMODE,
			PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			echo "Connection failed: " . $e->getMessage();
		}
	}
	
	public function viewData() {
		$query = "SELECT DISTINCT name FROM user_items GROUP BY name";
		$stmt = $this->con->prepare($query);
		$stmt->execute();
		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $data;
	}
	
	public function searchData($name) {
		$query = "SELECT DISTINCT name FROM user_items WHERE name LIKE :name GROUP BY name";
		$stmt = $this->con->prepare($query);
		$stmt->execute(["name" => "%" . $name . "%"]);
		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $data;
	}
}
?>