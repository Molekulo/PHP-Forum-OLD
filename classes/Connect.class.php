<?php
require_once "params.php"; 
class Connect {
	protected $conn;
	
	public function __construct() {
		$this->conn = new mysqli(HOST, USER, PASS, DB);
		if(!$this->conn) {
			echo "<h1 class='text-center'>Greška: Niste povezani sa bazom podataka. Pokušajte kasnije.</h1>";
     		exit;
		}
	}
}

