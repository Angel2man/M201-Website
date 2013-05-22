<?php
    // Load common functions
    require "includes/common.php";
    
    // Get session id
    $session_id = $_SESSION["session_id"];
    
    // If session id exists, log out
    if ($session_id != null) {
        auth_logout($db, $session_id);
        $_SESSION["session_id"] = null;
    }
    
    // Redirect to homepage
    header("Location: /index.php");
?>
