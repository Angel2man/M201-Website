<?php
    // Error messages
    $name_error = null;
    $address1_error = null;
    $address2_error = null;
    $town_error = null;
    $county_error = null;
    $postcode_error = null;
    $phone_error = null;
    
    // Success flag
    $success = false;
    
    // Check if were changing the password
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get field values
        $name = $_POST["name"];
        $address1 = $_POST["address1"];
        $address2 = $_POST["address2"];
        $town = $_POST["town"];
        $county = $_POST["county"];
        $postcode = $_POST["postcode"];
        $phone = $_POST["phone"];
        
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
            
            // Set success flag
            $success = true;
        }
    }
?>

<?php if($success) { ?>
    <h3>Successfully changed address!</h3>
    <p><a href="account.php">Go back to account settings</a></p>
<?php } else { ?>
    <form action="account.php?action=change_address" method="post">
        <div class="form">
            <div class="form_row">
                <div class="form_label">Name</div>
                <div class="form_field">
                    <input type="text" name="name" value="<?php echo $user["name"]; ?>" />
                    <div class="form_error"><?php if ($name_error) { echo $name_error; } ?></div>
                </div>
            </div>
            <div class="form_row">
                <div class="form_label">Address 1</div>
                <div class="form_field">
                    <input type="text" name="address1" value="<?php echo $user["address1"]; ?>" />
                    <div class="form_error"><?php if ($address1_error) { echo $address1_error; } ?></div>
                </div>
            </div>
            <div class="form_row">
                <div class="form_label">Address 2</div>
                <div class="form_field">
                    <input type="text" name="address2" value="<?php echo $user["address2"]; ?>" />
                    <div class="form_error"><?php if ($address2_error) { echo $address2_error; } ?></div>
                </div>
            </div>
            <div class="form_row">
                <div class="form_label">Town/City</div>
                <div class="form_field">
                    <input type="text" name="town" value="<?php echo $user["town"]; ?>" />
                    <div class="form_error"><?php if ($town_error) { echo $town_error; } ?></div>
                </div>
            </div>
            <div class="form_row">
                <div class="form_label">County</div>
                <div class="form_field">
                    <input type="text" name="county" value="<?php echo $user["county"]; ?>" />
                    <div class="form_error"><?php if ($county_error) { echo $county_error; } ?></div>
                </div>
            </div>
            <div class="form_row">
                <div class="form_label">Postcode</div>
                <div class="form_field">
                    <input type="text" name="postcode" value="<?php echo $user["postcode"]; ?>" />
                    <div class="form_error"><?php if ($postcode_error) { echo $postcode_error; } ?></div>
                </div>
            </div>
            <div class="form_row">
                <div class="form_label">Phone</div>
                <div class="form_field">
                    <input type="text" name="phone" value="<?php echo $user["phone"]; ?>" />
                    <div class="form_error"><?php if ($phone_error) { echo $phone_error; } ?></div>
                </div>
            </div>
            <div class="form_row">
                <input type="submit" value="Save" />
            </div>
        </div>
    </form>
<?php } ?>
