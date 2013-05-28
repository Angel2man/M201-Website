<?php
    // Check if were closing the account
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get confirmation
        $confirm = $_POST["confirm"];
        
        // If confirm is true, close the account
        if ($confirm == "true") {
            // Close account
            auth_close_account($db, $user["id"]);
            
            // Logout of session
            auth_logout($db, $_SESSION["session_id"]);
            $_SESSION["session_id"] = null;
            
            // Set message
            $_SESSION["message"] = "Your account has been closed";
            
            // Forward to home page
            header("Location: index.php");
        }
    }
?>

<p>You account cannot be reopened once it is closed</p>

<form action="account.php?action=close_account" method="post">
    <input type="hidden" name="confirm" value="true" />
    <input type="submit" value="Close account" />
</form>
