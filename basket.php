<?php
    // Load common functions
    require "includes/common.php";
    
    // Check if user is not logged in
    if (!$user) {
        // Forward user to login page with next parameter set to this page
        forward("login.php?next=basket.php", null);
    }
    
    // Check for users basket if were not changing it
    if (!$user["basket"] && $_GET["action"] != "change_item") {
        // Print error
        require "includes/header.php";
        echo "<p>Your basket is empty</p>";
        require "includes/footer.php";
        die();
    }
    
    // Set page variables
    $page["title"] = "Basket";
    
    // Check if were changing a basket item
    if ($_GET["action"] == "change_item") {
        // Header
        require "includes/header.php";
        
        // Print change item page
        require "includes/basket/change_item.php";
    } else if ($_GET["action"] == "checkout") { // Check if were checking out
        // Change title to checkout
        $page["title"] = "Checkout";
        
        // Add some breadcrumb
        $page["breadcrumb"] = array(
            array("Basket", "basket.php"),
            array("Checkout", null)
        );
        
        // Header
        require "includes/header.php";
        
        // If were posting, run do_checkout
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
    } else { // Print basket
        // Header
        require "includes/header.php";
        
        // Print basket page
        require "includes/basket/basket.php";
    }
    
    // Footer
    require "includes/footer.php";
?>
