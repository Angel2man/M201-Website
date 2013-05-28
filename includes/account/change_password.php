<?php
    // Error message
    $password_error = null;
    
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
            //auth_change_password($db, $user["id"], $password1);
            
            // Forward to account page
            forward("account.php", "Successfully changed password");
        }
    }
?>

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

