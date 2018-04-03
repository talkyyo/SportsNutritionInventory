<?php
	// connects to database
	function databaseConnection() {
		require_once('/home/jttalkin/seniorProjectServerConnection.php');
		$mysqli = new mysqli(DBHOST, USERNAME, PASSWORD, DBNAME);
		
		if($mysqli->connect_errno){
			die("Could not connect to server".DBHOST."<br />");
		}
		return $mysqli;
	}

	function generateSalt($length) {
	  // MD5 returns 32 characters
	  $unique_random_string = md5(uniqid(mt_rand(), true));
	  
	  // Valid characters for a salt are [a-zA-Z0-9./]
	  $base64_string = base64_encode($unique_random_string);
	  
	  // Replace '+' with '.' from the base64 encoding
	  $modified_base64_string = str_replace('+', '.', $base64_string);
	  
	  // Truncate string to the correct length
	  $salt = substr($modified_base64_string, 0, $length);
	  
		return $salt;
	}

	//uses Blowfish to salt and encrypt password
	function password_encrypt($password){
		$hashFormat = "$2y$10$";
		
		$saltLength = 22;
		
		$salt = generateSalt($saltLength);

		$formatAndSalt = $hashFormat . $salt;

		$hash = crypt($password, $formatAndSalt);

		return $hash;
	}


	function passwordCheck($password, $existing_hash) {
	  // existing hash contains format and salt at start
	  $hash = crypt($password, $existing_hash);
	  if ($hash === $existing_hash) {
	    return true;
	  } 
	  else {
	    return false;
	  }
	}

	function debug_to_console( $data, $context = 'Debug in Console' ) {

    // Buffering to solve problems frameworks, like header() in this and not a solid return.
    ob_start();

    $output  = 'console.info( \'' . $context . ':\' );';
    $output .= 'console.log(' . json_encode( $data ) . ');';
    $output  = sprintf( '<script>%s</script>', $output );

    echo $output;
	}
?>