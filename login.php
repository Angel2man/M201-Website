<?php
    // Load common functions
    require "includes/common.php";
    
    // Initialise error flag
    $error = false;
    
    // Get next parameter
    $next = $_GET["next"];
    
    // Check if the user is logging in
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get username and password
        $username = $_POST["username"];
        $password = $_POST["password"];
        
        // Validate username and password
        // We allow email addresses to be used as usernames
        if ((validate_username($username) != null && validate_email_address($username) != null) || validate_password($password, $password) != null) {
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
                    
                    // Redirect
                    if ($next) {
                        forward($next, null);
                    } else {
                        forward("index.php", null);
                    }
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

        
<?php if ($next) { ?>
    <p>You must login to view this page</p>
    <form action="login.php?next=<?php echo $next; ?>" method="post">
<?php } else { ?>
    <form action="login.php" method="post">
<?php } ?>


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
