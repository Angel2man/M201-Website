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
