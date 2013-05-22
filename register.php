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
        
        // Check that all fields are set
        if ($username == null || $username == "") {
            $username_error = "This field is required";
        }
        if ($email == null || $email == "") {
            $email_error = "This field is required";
        }
        if ($password1 == null || $password1 == "") {
            $password_error = "This field is required";
        } else {
            if ($password2 == null || $password2 == "") {
                $password_error = "Please repeat password";
            }
        }
        
        // Check that the username is valid
        if ($username_error == null) {
            // Must be less than 256 characters and alphanumeric (underscores allowed)
            if (strlen($username) > 256 || !preg_match("/^[a-zA-Z0-9_]+$/", $username)) {
                $username_error = "This username is invalid";
            } else if (strlen($username) < 4) { // Must have 4 or more characters
                $username_error = "This username is too short";
            } else {
                // Check that the username isnt already in use
                if (auth_check_username_exist($db, $username)) {
                    $username_error = "This username is already in use";
                }
            }
        }
        
        // Check that the email is valid
        if ($email_error == null) {
            // http://php.net/manual/en/filter.examples.validation.php
            if (strlen($email) > 256 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $email_error = "This email address is invalid";
            } else {
                // Check that the email address isnt already in use
                if (auth_check_email_exist($db, $email)) {
                    $email_error = "This email address is already in use";
                }
            }
        }
        
        // Check that the passwords match
        if ($password_error == null) {
            if ($password1 != $password2) {
                $password_error = "These passwords do not match";
            }
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

    <p>Thank you for registering</p>
    <p>An activation link has been emailed to you and should arrive shortly</p>
    <p>You can <a href="/login.php">log in now</a> but you cannot place an order until your email has been verified</p>

<?php } else { ?>

    <form action="/register.php" method="post">
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
