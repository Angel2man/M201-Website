<?php
    // Load common functions
    require "includes/common.php";
    
    
    // Work out action
    $action = $_GET["action"];
    
    // Make sure action is in an allowed list
    $allowed_actions = array("change_item", "checkout");
    if ($action && !in_array($action, $allowed_actions)) {
        $action = null;
    }
    
    // Change item must only be a POST request
    if ($action == "change_item" && $_SERVER["REQUEST_METHOD"] != "POST") {
        forward("basket.php", null);
    }
    
    // Check if user is not logged in
    if (!$user) {
        // Forward user to login page with next parameter set to this page
        if ($action) {
            forward("login.php?next=basket.php%3Faction%3D".$action, null);
        } else {
            forward("login.php?next=basket.php", null);
        }
    }
    
    // Set page variables
    if (!$action) {
        $page["title"] = "Basket";
    } else if ($action == "checkout") {
        // Change title to checkout
        $page["title"] = "Checkout";
        
        // Breadcrumb
        $page["breadcrumb"] = array(
            array("Basket", "basket.php"),
            array("Checkout", null)
        );
    }
    
    // If were changing an item
    if ($action == "change_item") {
        // Run change item
        require "includes/basket/change_item.php";
    } else {
        // Add the header
        require "includes/header.php";
        
        // Check that the basket has items
        if ($user["basket"]) {
            // Check if were checking out
            if ($action == "checkout") {
                // If this is a post request, do checkout
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    // Run do checkout
                    require "includes/basket/do_checkout.php";
                    
                    // If theres a validation error, print out checkout page
                    if ($address_invalid) {
                        require "includes/basket/checkout.php";
                    }
                } else {
                    // Get address
                    $name = $user["name"];
                    $address1 = $user["address1"];
                    $address2 = $user["address2"];
                    $town = $user["town"];
                    $county = $user["county"];
                    $postcode = $user["postcode"];
                    $phone = $user["phone"];
                    
                    // Print checkout page
                    require "includes/basket/checkout.php";
                }
            } else {
                // Print basket page
                require "includes/basket/basket.php";
            }
        } else {
            // Print error
            echo "<p>Your basket is empty</p>";
        }
        
        // Add the footer
        require "includes/footer.php";
    }
?>
