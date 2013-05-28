<?php
    // Error message
    $error = null;
    
    // Check if were resending a verification email
    if ($_POST["resend_verification_email"] == "true") {
        // Resend verification email to this user
        auth_resend_verification_email($db, $user["id"]);
        
        // Forward to thos page
        forward("account.php?action=verify_email", "Sending another verification email");
    }
?>


<?php if ($user["email_verified"]) { ?>
   <h3>Your email has already been verified</h3>
   <p><a href="account.php">Click here</a> to go back to your account settings</p>
<?php } else { ?>
    <h3>Your email has not been verified yet</h3>
    <p>You should have recieved an email to &quot;<?php echo $user["email"]; ?>&quot; containing a link to verify your email address</p>
    
    <hr />
    
    <p>If you cannot click the link, please copy the activation code provided in the email into the box below</p>
    <form action="verify_email.php" method="get">
        <input type="text" size="32" name="key" />
        <input type="submit" value="Verify" />
    </form>
    
    <hr />
    
    <p>If you have not recieved the email, click the button below to send another email</p>
    <form action="account.php?action=verify_email" method="post">
        <input type="hidden" name="resend_verification_email" value="true" />
        <input type="submit" value="Resend verification email" />
    </form>
<?php } ?>
