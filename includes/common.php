<?php
    // Start session
    session_start();
    
    // Includes
    require "db.php";
    require "crypt.php";
    require "auth.php";
    require "validation.php";
    
    // Connect to database
    $db = db_connect();
    
    // Find logged in user
    $user = null;
    if ($_SESSION["session_id"]) {
        $user = db_get_user_from_session_id($db, $_SESSION["session_id"]);
        
        // Find users basket
        if ($user) {
            $user["basket"] = db_get_basket_from_user_id($db, $user["id"]);
        }
    }
    
    function forward($to, $message) {
		// Set message
		if ($message) {
			$_SESSION["message"] = $message;
		}
		
		// Forward
		header("Location: ".$to);
		
		// Die
		die("<p>Forwarding to <a href=\"$to\">$to</a></p>");
	}
	
	function print_stars($total, $on) {
		// Work out how many off stars there are
		$off = $total - $on;
		
		// Loop through on stars
		for ($i = 0; $i < $on; $i++) {
			echo "<img src=\"static/star_on.png\" alt=\"*\" />";
		}
		
		// Loop through off stars
		for ($i = 0; $i < $off; $i++) {
			echo "<img src=\"static/star_off.png\" alt=\"-\" />";
		}
	}
?>
