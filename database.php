<?php
	
Class Database {
	
	private $db;
	
	 function createConnection() {
		 
		try {
		$config = require_once 'config.php';
		$this->db = new PDO("mysql:host={$config['host']};dbname={$config['database']};charset=utf8", $config['user'], $config['password'], [
		PDO::ATTR_EMULATE_PREPARES => false, 
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
		
	} catch (PDOException $error) {
		
		exit('Database error');
	}
		return $this->db; 
		 
	 }
	
};

