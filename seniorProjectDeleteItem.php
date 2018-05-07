<?php
	//require session and required functions
	require_once('seniorProjectSession_Functions.php');
	require_once('seniorProjectRequiredFunctions.php');

	//if error or alert is found, print it
	if (($message = message()) !== null) {
		echo $message;
	}

	//calls method to establish connection to server
	$mysqli = databaseConnection();

	//verify that session ID exists
  	verifyLogin();

	if(isset($_GET["itemID"]) && $_GET["itemID"] !== "") {
		$deleteItem = $_GET["itemID"];

		$query = "DELETE FROM Inventory ";
		$query .= "WHERE InventoryNum = ".$deleteItem;

		$result = $mysqli->query($query);

		if ($result) {
			$_SESSION["alert"] = "Item successfully deleted!";
			header("Location: seniorProjectLanding.php");
		}
		else {
			$_SESSION["error"] = "Item could not be deleted!";
			header("Location: seniorProjectLanding.php");
			exit;
		}
	}
	else {
		$_SESSION["error"] = "Item could not be found!";
		header("Location: seniorProjectLanding.php");
		exit;
	}

?>