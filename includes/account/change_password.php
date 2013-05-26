<?php
    // Error message
    $password_error = null;
    
    // Success flag
    $success = false;
    
    // Check if were changing the password
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get field values
        $password1 = $_POST["password1"];
        $password2 = $_POST["password2"];
        
        // Validate password
        $password_error = validate_password($password1, $password2);
        
        // If password is valid, change it
        if ($password_error == null) {
            // Change password
            auth_change_password($db, $user["id"], $password1);
            
            // Set success flag
            $success = true;
        }
    }
?>

<?php if($success) { ?>
    <h3>Successfully changed password!</h3>
    <p><a href="account.php">Go back to account settings</a></p>
<?php } else { ?>
    <form action="account.php?action=change_password" method="post">
        <div class="form">
            <div class="form_row">
                <div class="form_label">Password</div>
                <div class="form_field">
                    <input type="password" name="password1" /><br />
                    <sub>Repeat password</sub><br />
                    <input type="password" name="password2" />
                    <div class="form_error"><?php if ($password_error) { echo $password_error; } ?></div>
                </div>
            </div>
            <div class="form_row">
                <input type="submit" value="Change Password" />
            </div>
        </div>
    </form>
<?php } ?>
