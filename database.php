<?php
	$dbName   = "project";
	$un = "project";
	$password = "Ap120580";
	$host = "localhost";
	
	$dsn = "mysql:host=$host;dbname=$dbName";
	
	try {
		$db = new PDO($dsn, $un, $password);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $e) {
		error_log("Database connection error: Reason: " . $e->getMessage(), 0);
		include('database_error.html');
		exit();
	}
?>