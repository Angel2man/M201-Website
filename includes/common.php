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
	
	function print_price($current, $usual) {
		// Print current price
		echo money_format("£%i", $current / 100);
		
		// If usual price is different, print that as well
		if ($current != $usual) {
			echo " <sub>".money_format("£%i", $usual / 100)."</sub> ";
		}
	}
?>
