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

	debug_to_console($_SESSION["Username"]);

?>

<!DOCTYPE html>
<html lang = "en">
  <head>
  	<title>Sports Nutrition Inventory System</title>

  	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<script src="assets/js/jquery.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
  </head>

<body>
	<nav class="navbar navbar-inverse navbar-fixed-top" style="background-color: #00336f">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="seniorProjectLanding.php"><i class="glyphicon glyphicon-home" style="color: white"></i></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
        	<ul class="nav navbar-nav navbar-right">
        		<li><a href="#" style="color: white"><?php $firstName = "SELECT FirstName FROM User WHERE Username = '".$_SESSION["Username"]."' LIMIT 1"; $result = $mysqli->query($firstName); $row = $result->fetch_assoc(); echo $row["FirstName"]; 
        		echo " "; $lastName = "SELECT LastName FROM User WHERE Username = '".$_SESSION["Username"]."' LIMIT 1"; $result2 = $mysqli->query($lastName); $row = $result2->fetch_assoc(); echo $row["LastName"]; echo " "; ?> 
        		<i class="glyphicon glyphicon-user" style="color: white"></i></a></li>
        		<li><a href="seniorProjectLogout.php" style="color: white">Logout</a></li>
        	</ul>
        </div>
       </div>
    </nav>
</body>