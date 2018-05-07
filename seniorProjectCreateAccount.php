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

	//if submit button is clicked
	if (isset($_POST["Submit"])) {
		//if all input fields are filled in and not blank
		if (isset($_POST["Username"]) && $_POST["Username"] !== "" && isset($_POST["Password"]) && $_POST["Password"] !== "" && isset($_POST["confirmPassword"]) && $_POST["confirmPassword"] !== "" && isset($_POST["Email"]) && $_POST["Email"] !== "" && isset($_POST["FirstName"]) && $_POST["FirstName"] !== "" && isset($_POST["LastName"]) && $_POST["LastName"] !== "") {

			$username = $_POST["Username"];
			$password = password_encrypt($_POST["Password"]);
			$email = $_POST["Email"];
			$firstname = $_POST["FirstName"];
			$lastname = $_POST["LastName"];

			//checks if username already exists
			$usernameCheck = mysqli_query("SELECT FROM User WHERE Username = ".$username."");
			if(mysqli_num_rows($usernameCheck) >= 1) {
				$_SESSION["error"] = "Username already exists!";
				header("Location: seniorProjectCreateAccount.php");
			}
			else {
				//pass
			}

			//if password and confirm password field match
			if ($_POST["Password"] == $_POST["confirmPassword"]) {
				//query to insert into User table
				$query = "INSERT INTO User ";
				$query .= "(Username, FirstName, LastName, Email) ";
				$query .= "VALUES ('";
				$query .= $username."', '";
				$query .= $firstname."', '";
				$query .= $lastname."', '";
				$query .= $email."')";

				$result = $mysqli->query($query);

				//query to insert into Login table, keeping the username and password combinations seperate from the User's basic info
				$query2 = "INSERT INTO Login ";
				$query2 .= "(Username, Password) ";
				$query2 .= "VALUES ('";
				$query2 .= $username."', '";
				$query2 .= $password."')";

				$result2 = $mysqli->query($query2);

				if ($result && $result2) {
					$_SESSION["alert"] = "User added!";
					header("Location: seniorProjectLogin.php");
				}
				else {
					$_SESSION["error"] = "Could not add user";
					header("Location: seniorProjectLogin.php");
				}
			}
			else {
				$_SESSION["error"] = "Passwords did not match";
				header("Location: seniorProjectCreateAccount.php");
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
	    padding-top: 5px;
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

  &nbsp

  	<body style = "background-color: #00336f">
  		<div class="container">
  			<div class="jumbotron">
  				<h2 class="text-center">Create Account</h2>
  				<form action="seniorProjectCreateAccount.php" method="POST">
  					<div class="form-group">
  					<label for="Username">Username:</label>
  					<input type="text" class="form-control" name="Username" id="Username" placeholder="Username" required>
  					</div>
  					<div class="form-group">
						<label for="Password">Password:</label>
						<input type="password" name="Password" class="form-control" id="Password" placeholder="Password" required>
					</div>
					<div class="form-group">
						<label for="confirmPassword">Confirm Password:</label>
						<input type="password" name="confirmPassword" class="form-control" id="confirmPassword" placeholder="Password" required>
					</div>
					<div class="form-group">
						<label for="Email">Email Address:</label>
						<input type="email" name="Email" class="form-control" id="Email" placeholder="Email Address" required>
					</div>
					<div class="form-group">
  					<label for="FirstName">First Name:</label>
  					<input type="text" class="form-control" name="FirstName" id="FirstName" placeholder="First Name" required>
  					</div>
  					<div class="form-group">
  					<label for="LastName">Last Name:</label>
  					<input type="text" class="form-control" name="LastName" id="LastName" placeholder="Last Name" required>
  					</div>
  					<div class="form-group">
						<button type="submit" name="Submit" class="btn btn-primary">Create Account</button>
					</div>
  				</form>
  			</div>
  		</div>
  	</body>