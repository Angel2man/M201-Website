<?php
    // Load common functions
    require "includes/common.php";
    
    // Set page variables
    $page["title"] = "Checkout";
    
    // Get basket
    $basket = null;
    if ($user) {
        $basket = db_get_basket_from_user_id($db, $user["user_id"]);
    }
    
    
    
    // Print header
    require "includes/header.php";
    
    // If user is logged in
    if ($user) {
        // If user has items in their basket
        if ($basket) {
            /
    ?>
    
    
    
    
    <?php
        } else {
            // Print basket empty message
            echo "<p>Your basket is empty</p>";
        }
    } else {
        // Print login message
        echo "<p>You must <a href=\"login.php\">login</a> in order to view this page</p>";
    }
    
    // Print footer
    require "includes/footer.php";
?>
