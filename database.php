<?php

Class Database {
	
	function createConnection() {
		try {
			
			$config = require_once 'config.php';
			$connection = new PDO("mysql:host={$config['host']};dbname={$config['database']};charset=utf8", $config['user'], $config['password'], [
			PDO::ATTR_EMULATE_PREPARES => false, 
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
			
		} catch (PDOException $error) {
			
			exit('Database error');
		}
		return $connection;
	}
}