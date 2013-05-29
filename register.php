<?php
    // Load common functions
    require "includes/common.php";
    
    // Initialise fields
    $username = "";
    $email = "";
    $password1 = "";
    $password2 = "";
    
    // Successful flag
    $successful = false;
    
    // Error messages
    $username_error = null;
    $email_error = null;
    $password_error = null;
    
    // Check if were registering a new user
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get field values
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password1 = $_POST["password1"];
        $password2 = $_POST["password2"];
        
        // Validate input
        $username_error = validate_username($username);
        $email_error = validate_email_address($email);
        $password_error = validate_password($password1, $password2);
        
        // Check if username is already taken
        if ($username_error == null && auth_check_username_exist($db, $username)) {
            $username_error = "This username is already in use";
        }
        
        // Check if email address is already taken
        if ($email_error == null && auth_check_email_exist($db, $username)) {
            $email_error = "This email address is already in use";
        }
        
        // If there are no errors, continue with registration
        if($username_error == null && $email_error == null && $password_error == null) {
            // Register
            auth_register($db, $username, $email, $password1);
            
            // Set successful flag
            $successful = true;
        }
    }
    
    // Set page variables
    if ($successful) {
        $page["title"] = "Registration successful";
    } else {
        $page["title"] = "Register";
    }
?>



<?php require "includes/header.php" ?>

<?php if ($successful) { ?>

    <h3>Thank you for registering!</h3>
    <p>An activation link has been emailed to you and should arrive shortly</p>
    <p>You can now login but you cannot place an order until your email has been verified</p>
    
    <h3><a href="login.php">Click here to login</a></h3>

<?php } else { ?>

    <form action="register.php" method="post">
        <div class="form">
            <div class="form_row">
                <div class="form_label">Username</div>
                <div class="form_field">
                    <input type="text" name="username" value="<?php echo $username; ?>" />
                    <div class="form_error"><?php if ($username_error) { echo $username_error; } ?></div>
                </div>
            </div>
            <div class="form_row">
                <div class="form_label">Email</div>
                <div class="form_field">
                    <input type="text" name="email" value="<?php echo $email; ?>" />
                    <div class="form_error"><?php if ($email_error) { echo $email_error; } ?></div>
                </div>
            </div>
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
                <input type="submit" value="Register" />
            </div>
        </div>
    </form>

<?php } ?>

<?php require "includes/footer.php" ?>
