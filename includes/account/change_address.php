<?php
    // Error messages
    $name_error = null;
    $address1_error = null;
    $address2_error = null;
    $town_error = null;
    $county_error = null;
    $postcode_error = null;
    $phone_error = null;
    
    // Set field values to current ones
    $name = $user["name"];
    $address1 = $user["address1"];
    $address2 = $user["address2"];
    $town = $user["town"];
    $county = $user["county"];
    $postcode = $user["postcode"];
    $phone = $user["phone"];
    
    // Check if were changing the address
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get field values
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
        $name_error = validate_address_line($name, false);
        $address1_error = validate_address_line($address1, false);
        $address2_error = validate_address_line($address2, false);
        $town_error = validate_address_line($town, false);
        $county_error = validate_address_line($county, false);
        $postcode_error = validate_address_postcode($postcode, false);
        $phone_error = validate_address_phone_number($phone, false);
        
        // If address is valid, change it
        if ($name_error == null && $address1_error == null &&
            $address2_error == null && $town_error == null &&
            $county_error == null && $postcode_error == null &&
            $phone_error == null) {
            // Change address
            auth_change_address($db, $user["id"], $name, $address1, $address2, $town, $county, $postcode, $phone);
            
            // Forward to account page
            forward("account.php", "Successfully changed address");
        }
    }
?>

<form action="account.php?action=change_address" method="post">
    <div class="form">
        <div class="form_row">
            <div class="form_label">Name</div>
            <div class="form_field">
                <input type="text" name="name" value="<?php echo $name; ?>" />
                <div class="form_error"><?php if ($name_error) { echo $name_error; } ?></div>
            </div>
        </div>
        <div class="form_row">
            <div class="form_label">Address 1</div>
            <div class="form_field">
                <input type="text" name="address1" value="<?php echo $address; ?>" />
                <div class="form_error"><?php if ($address1_error) { echo $address1_error; } ?></div>
            </div>
        </div>
        <div class="form_row">
            <div class="form_label">Address 2</div>
            <div class="form_field">
                <input type="text" name="address2" value="<?php echo $address2; ?>" />
                <div class="form_error"><?php if ($address2_error) { echo $address2_error; } ?></div>
            </div>
        </div>
        <div class="form_row">
            <div class="form_label">Town/City</div>
            <div class="form_field">
                <input type="text" name="town" value="<?php echo $town; ?>" />
                <div class="form_error"><?php if ($town_error) { echo $town_error; } ?></div>
            </div>
        </div>
        <div class="form_row">
            <div class="form_label">County</div>
            <div class="form_field">
                <input type="text" name="county" value="<?php echo $county; ?>" />
                <div class="form_error"><?php if ($county_error) { echo $county_error; } ?></div>
            </div>
        </div>
        <div class="form_row">
            <div class="form_label">Postcode</div>
            <div class="form_field">
                <input type="text" name="postcode" value="<?php echo $postcode; ?>" /><sub>Don't forget the space!</sub>
                <div class="form_error"><?php if ($postcode_error) { echo $postcode_error; } ?></div>
            </div>
        </div>
        <div class="form_row">
            <div class="form_label">Phone</div>
            <div class="form_field">
                <input type="text" name="phone" value="<?php echo $phone; ?>" />
                <div class="form_error"><?php if ($phone_error) { echo $phone_error; } ?></div>
            </div>
        </div>
        <div class="form_row">
            <input type="submit" value="Save" />
        </div>
    </div>
</form>
