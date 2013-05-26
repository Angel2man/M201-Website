<h3>Details</h3>
<div class="form">
    <div class="form_row">
        <div class="form_label">Username</div>
        <div class="form_field">
            <?php echo $user["username"]; ?>
        </div>
    </div>
    <div class="form_row">
        <div class="form_label">Email</div>
        <div class="form_field">
            <?php echo $user["email"]; ?> <sub>(<?php if (!$user["email_verified"]) { echo "Not "; } ?> Verified)</sub>
            <?php if (!$user["email_verified"]) { ?><br /><sub><a href="account.php?action=verify_email">Verify my email address</a></sub><?php } ?>
        </div>
    </div>
    <div class="form_row">
        <div class="form_label">Password</div>
        <div class="form_field">
            ******** <sub><a href="account.php?action=change_password">Change Password</a></sub>
        </div>
    </div>
    <div class="form_row">
        <div class="form_label">Address</div>
        <div class="form_field">
            <sub><a href="account.php?action=change_address">Change Address</a></sub><br/>
            <?php echo $user["name"]; ?><br />
            <?php echo $user["address1"]; ?><br />
            <?php echo $user["address2"]; ?><br />
            <?php echo $user["town"]; ?><br />
            <?php echo $user["county"]; ?><br />
            <?php echo $user["postcode"]; ?><br />
            <?php echo $user["phone"]; ?>
        </div>
    </div>
</div>
<h3 style="padding-top: 20px;">Close account</h3>
<a href="account.php?action=close_account">Close account</a></p>
