<?php
	// connects to database
	function dbConnection() {
		require_once('/home/jttalkin/seniorProjectServerConnection.php');
		$mysqli = new mysqli(DBHOST, USERNAME, PASSWORD, DBNAME);
		
		if($mysqli->connect_errno){
			die("Could not connect to server".DBHOST."<br />");
		}
		return $mysqli;
	}