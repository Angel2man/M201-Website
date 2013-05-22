<?php if ($user["email_verified"]) { ?>
   <h3>Your email has been verified</h3>
   <p><a href="/account.php">Click here</a> to go back to your account settings</p>
<?php } else { ?>
    <h3>Your email has not been verified yet</h3>
    <p>You should have recieved an email to &quot;<?php echo $user["email"]; ?>&quot; containing a link to verify your email address</p>
    
    <hr />
    
    <p>If you cannot click the link, please copy the activation code provided in the email into the box below</p>
    <form action="/account.php" method="get">
        <input type="hidden" name="action" value="verify_email" />
        <input type="text" name="key" />
        <input type="submit" value="Activate" />
    </form>
    
    <hr />
    
    <p>If you have not recieved the email, click the button below to send another email</p>
    <form action="/account.php?action=verify_email" method="post">
        <input type="hidden" name="resend_verification_email" value="true" />
        <input type="submit" value="Resend activation email" />
    </form>
<?php } ?>
