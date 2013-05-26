<?php
    // Load common functions
    require "includes/common.php";
    
    // Initialise error flag
    $error = false;
    
    // Check if the user is logging in
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get username and password
        $username = $_POST["username"];
        $password = $_POST["password"];
        
        // Validate username and password
        if (validate_username($username) != null || validate_password($password, $password) != null) {
            $error = true;
        } else {
            // Check credentials
            $user_id = auth_get_user_id_from_credentials($db, $username, $password);
            if ($user_id != null) {
                // Login user
                $session_id = auth_login($db, $user_id, $_SERVER["REMOTE_ADDR"]);
                if ($session_id != null) {
                    // Set session id
                    $_SESSION["session_id"] = $session_id;
                    
                    // Redirect to home page
                    header("Location: index.php");
                } else {
                    die("Failed to create new session :'(");
                }
            } else {
                $error = true;
            }
        }
    }
    
    // Set page variables
    $page["title"] = "Login";
?>



<?php require "includes/header.php" ?>

<form action="login.php" method="post">
    <div class="form">
        <?php if ($error) { ?>
            <div class="form_error">Invalid Username/Password</div>
        <?php } ?>
        <div class="form_row">
            <div class="form_label">Username</div>
            <div class="form_field"><input type="text" name="username" /></div>
        </div>
        <div class="form_row">
            <div class="form_label">Password</div>
            <div class="form_field"><input type="password" name="password" /></div>
        </div>
        <div class="form_row">
            <input type="submit" value="Login" /> <a href="register.php">Register</a>
        </div>
    </div>
</form>

<?php require "includes/footer.php" ?>
