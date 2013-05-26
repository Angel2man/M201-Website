<form action="account.php?action=change_address" method="post">
    <div class="form">
        <div class="form_row">
            <div class="form_label">Name</div>
            <div class="form_field">
                <input type="text" name="name" value="<?php echo $user["name"]; ?>" />
                <div class="form_error"><?php if ($name_error) { echo $name_error; } ?></div>
            </div>
        </div>
        <div class="form_row">
            <div class="form_label">Address 1</div>
            <div class="form_field">
                <input type="text" name="address1" value="<?php echo $user["address1"]; ?>" />
                <div class="form_error"><?php if ($address1_error) { echo $address1_error; } ?></div>
            </div>
        </div>
        <div class="form_row">
            <div class="form_label">Address 2</div>
            <div class="form_field">
                <input type="text" name="address2" value="<?php echo $user["address2"]; ?>" />
                <div class="form_error"><?php if ($address2_error) { echo $address2_error; } ?></div>
            </div>
        </div>
        <div class="form_row">
            <div class="form_label">Town/City</div>
            <div class="form_field">
                <input type="text" name="town" value="<?php echo $user["town"]; ?>" />
                <div class="form_error"><?php if ($town_error) { echo $town_error; } ?></div>
            </div>
        </div>
        <div class="form_row">
            <div class="form_label">County</div>
            <div class="form_field">
                <input type="text" name="county" value="<?php echo $user["county"]; ?>" />
                <div class="form_error"><?php if ($county_error) { echo $county_error; } ?></div>
            </div>
        </div>
        <div class="form_row">
            <div class="form_label">Postcode</div>
            <div class="form_field">
                <input type="text" name="postcode" value="<?php echo $user["postcode"]; ?>" />
                <div class="form_error"><?php if ($postcode_error) { echo $postcode_error; } ?></div>
            </div>
        </div>
        <div class="form_row">
            <div class="form_label">Phone</div>
            <div class="form_field">
                <input type="text" name="phone" value="<?php echo $user["phone"]; ?>" />
                <div class="form_error"><?php if ($phone_error) { echo $phone_error; } ?></div>
            </div>
        </div>
        <div class="form_row">
            <input type="submit" value="Save" />
        </div>
    </div>
</form>
