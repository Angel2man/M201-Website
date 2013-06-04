<?php
    // Get address
    $name = $_POST["name"];
    $address1 = $_POST["address1"];
    $address2 = $_POST["address2"];
    $town = $_POST["town"];
    $county = $_POST["county"];
    $postcode = $_POST["postcode"];
    $phone = $_POST["phone"];
    
    // Postcode must be uppercase
    $postcode = strtoupper($postcode);
    
    // Validate
    $name_error = validate_address_line($name, true);
    $address1_error = validate_address_line($address1, true);
    $address2_error = validate_address_line($address2, true);
    $town_error = validate_address_line($town, true);
    $county_error = validate_address_line($county, true);
    $postcode_error = validate_address_postcode($postcode, true);
    $phone_error = validate_address_phone_number($phone, true);
    
    // Check that the address is valid
    $address_invalid = false;
    if ($name_error == null && $address1_error == null &&
        $address2_error == null && $town_error == null &&
        $county_error == null && $postcode_error == null &&
        $phone_error == null) {
        
        // Place order
        $result = db_place_order($db, $user["user_id"], 500, 0.2, $name, $address1, $address2, $town, $county, $postcode, $phone);
        
        // Check if result is an error or is an order id
        $error = null;
        $order_id = null;
        if (is_numeric($result)) {
            $order_id = $result;
        } else {
            $error = $result;
        }
        
        // Print message
        if ($error) { ?>
            <h2>Unable to place order</h2>
            <p><?php echo $error; ?></p>
        <?php } else { ?>
            <h2>Thank you for your order</h2>
            <p>Your order number is: <?php echo $order_id; ?></p>
        <?php }
    } else {
        $address_invalid = true;
    }
?>
