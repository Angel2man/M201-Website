<?php
    // Start session
    session_start();
    
    // Includes
    require "db.php";
    require "auth.php";
    
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
?>
