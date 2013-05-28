<?php
    // Load common functions
    require "includes/common.php";
    
    // Error
    $error = null;
    
    // Get verification key
    $key = $_GET["key"];
    
    // If key is present
    if ($key) {
        // Validate key
        $error = validate_verification_key($key);
        
        // If key is valid
        if ($error == null) {
            // Try key
            if (auth_verify_email($db, $key)) {
                // Set message
                $_SESSION["message"] = "Your email address has been verified";
                
                // Forward to home page
                header("Location: index.php");
            } else {
                $error = "Verification key not recognised";
            }
        }
    }
    
    // Set page variables
    $page["title"] = "Verify Email";
?>



<?php require "includes/header.php" ?>

<?php if ($error) { ?>
    <div class="form_error"><?php echo $error; ?></div>
<?php } ?>

<p>You should have recieved an email containing a link to verify your email address</p>

<hr />

<form action="verify_email.php" method="get">
    <input type="text" size="32" name="key" value="<?php echo $key; ?>" />
    <input type="submit" value="Activate" />
</form>


<?php require "includes/footer.php" ?>
