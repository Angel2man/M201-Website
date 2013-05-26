<?php
    // Load common functions
    require "includes/common.php";
    
    // Work out action
    $action = $_GET["action"];
    
    // Make sure action is in an allowed list
    $allowed_actions = array("change_password", "change_address", "close_account", "verify_email");
    if ($action && !in_array($action, $allowed_actions)) {
        $action = null;
    }
    
    // Set page variables
    if (!$action) {
        $page["title"] = "Account Settings";
    } else {
        // Set page title to the action thats being performed
        switch ($action) {
            case "change_password":
                $page["title"] = "Change Password";
            break;
            case "change_address":
                $page["title"] = "Change Address";
            break;
            case "close_account":
                $page["title"] = "Close Account";
            break;
            case "verify_email":
                $page["title"] = "Verify Email Address";
            break;
        }
        
        // Breadcrumb
        $page["breadcrumb"] = array(
            array("Account Settings", "account.php"),
            array($page["title"], null)
        );
    }
    
    
    
    
    
    // Print header
    require "includes/header.php";
    
    // Check if user is logged in
    if ($user) {
        // Work out action
        switch ($action) {
            case "change_password":
                require "includes/account/change_password.php";
            break;
            case "change_address":
                require "includes/account/change_address.php";
            break;
            case "close_account":
                require "includes/account/close_account.php";
            break;
            case "verify_email":
                require "includes/account/verify_email.php";
            break;
            default:
                require "includes/account/details.php";
            break;
        }
    } else {
        // Display login message
        echo "<p>You must <a href=\"login.php\">login</a> in order to view this page</p>";
    }
    
    // Print footer
    require "includes/footer.php";
?>
