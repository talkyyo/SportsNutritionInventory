<style>
.alert{
    position: fixed;
    top: 50px;
    left: 2%;
    width: 96%;
}
</style>

<?php
	
	//starts new session or resumes existing session
	session_start();

	//Pops up message if an error or alert is passed.
	function message() {
		// Error message
		if (isset($_SESSION["error"])) {
			$output="<div class='alert alert-danger fade in'>";
			$output.="<button type='button' class='close' data-dismiss='alert'>&times;</button>";
  			$output.="<strong>Error!</strong> ".$_SESSION["error"];
			$output.="</div>";
			
			// clear message after use
			$_SESSION["error"] = null;
			return $output;
		}
		
		// Alert message
		if (isset($_SESSION["alert"])) {
			
			$output="<div class='alert alert-success fade in'>";
			$output.="<button type='button' class='close' data-dismiss='alert'>&times;</button>";
  			$output.="<strong>Success!</strong> ".$_SESSION["alert"];
			$output.="</div>";
			
			// clear message after use
			$_SESSION["alert"] = null;
			return $output;
		}
	}

	// Verifies that a user is logged in, if not, pushes them back to Login
	function verifyLogin(){
		if(!isset($_SESSION["Username"]) && $_SESSION["Username"] == NULL){
			$_SESSION["error"] = "You must login first!";
			header("Location: seniorProjectLogin.php");
			exit;
		}
	}	
?>