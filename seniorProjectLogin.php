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

	//if user is already logged in, redirect to landing page
	if (isset($_SESSION['Username'])) {
		header('Location: seniorProjectLanding.php');
	}

	//if submit button is pressed
	if (isset($_POST["Submit"])) {
		if (isset($_POST["Username"]) && $_POST["Username"] !== "" && isset($_POST["Password"]) && $_POST["Password"] !== "") {
			
			$username = $_POST["Username"];
			$password = $_POST["Password"];

			$query = "SELECT * FROM ";
			$query .= "Login WHERE ";
			$query .= "Username = '".$username."' ";
			$query .= "LIMIT 1";

			$result = $mysqli->query($query);

			//checks if username/password combination are stored in database
			if ($result && $result->num_rows > 0) {
				$row = $result->fetch_assoc();
				//checks if hashed entered password matches stored hashed password
				if (passwordCheck($password, $row["Password"])) {
					$_SESSION["Username"] = $row["Username"];
					header("Location: seniorProjectLanding.php");
					exit;
				}
				else {
					$_SESSION["error"] = "Username/Password does not match!";
					header("Location: seniorProjectLogin.php");
					exit;
				}
			}		
		}
	}
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
  <style>
	.container {
	    width: 90%;
	    padding-top: 80px;
	    position: absolute-center;
	}

	/*styling for submit button*/
.btn-primary {
  color: #fff;
  background-color: #00336f;
  border-color: #00336f;
}

.btn-primary:hover {
  color: #fff;
  background-color: #00336f;
  border-color: #fff;
}

.btn-primary:focus, .btn-primary.focus {
  box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.5);
}

.btn-primary.disabled, .btn-primary:disabled {
  background-color: #007bff;
  border-color: #007bff;
}

.btn-primary:active, .btn-primary.active,
.show > .btn-primary.dropdown-toggle {
  background-color: #0069d9;
  background-image: none;
  border-color: #0062cc;
}
  </style>

	<body style = "background-color: #00336f">
  	<!-- form for login -->
  		<div class="container">
  			<div class="jumbotron">
  				<h2 class="text-center">Please Login</h2>
  				<form action="seniorProjectLogin.php" method="POST">
  					<div class="form-group">
  						<label for="Username">Username:</label>
  						<input type="text" class="form-control" name="Username" id="Username" placeholder="Username" required>
  					</div>
  					<div class="form-group">
  						<label for="Password">Password:</label>
  						<input type="password" class="form-control" name="Password" id="Password" placeholder="Password" required>
  					</div>
					<div class="form-group">
						<div class="checkbox">
							<label>
								<input type="checkbox"> Remember me
							</label>
						</div>
					</div>
					<div class="form-group">
						<button type="submit" name="Submit" class="btn btn-primary">Sign in</button>
					</div>
					<div class="form-group">
						<a href="seniorProjectCreateAccount.php">Create Account</a>
					</div>
  				</form>
  			</div>
  		</div>
  	</body>
</html>
