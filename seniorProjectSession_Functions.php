<?php
	
	//starts new session or resumes existing session
	session_start();

	//Pops up message if an error or alert is passed.
	function message() {
		// Error message
		if (isset($_SESSION["error"])) {
			$output="<div class='alert alert-danger fade in'>";
  			$output.="<strong>Error!</strong> ".$_SESSION["error"];
			$output.="</div>";
			
			// clear message after use
			$_SESSION["error"] = null;
			return $output;
		}
		
		// Alert message
		if (isset($_SESSION["alert"])) {
			
			$output="<div class='alert alert-success fade in'>";
  			$output.="<strong>Success!</strong> ".$_SESSION["alert"];
  			$output.="<a class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
			$output.="</div>";
			
			// clear message after use
			$_SESSION["alert"] = null;
			return $output;
		}
	}

	// Verifies that a user is logged in, if not, pushes them back to Login
	function verifyLogin(){
		if(!isset($_SESSION["userID"]) && $_SESSION["userID"] == NULL){
			$_SESSION["error"] = "You must login first!";
			header("Location: seniorProjectLogin.php");
			exit;
		}
	}	
?>