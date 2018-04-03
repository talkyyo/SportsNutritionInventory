<?php 
	require_once("seniorProjectSession_Functions.php");
	
	//resets sessions of user
	session_unset();

	//redirects back to Login page
	header("Location: seniorProjectLogin.php");
	exit;
 ?>