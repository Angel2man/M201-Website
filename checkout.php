<?php
    // Load common functions
    require "includes/common.php";
    
    // Set page variables
    $page["title"] = "Checkout";
    
    // Get basket
    $basket = null;
    if ($user) {
        $basket = db_get_basket_from_user_id($db, $user["user_id"]);
    }
   
    // Initialise total value 
    $total_value = 0;
    
    
    
    
    
    // Print header
    require "includes/header.php";
    
    // If user is logged in
    if ($user) {
        if ($basket) {
    ?>
        <h3>Items</h3>
        <table style="width: 500px; padding-bottom: 50px; text-align: center; border-spacing: 10px;">
            <thead>
               <tr>
                   <th>Product</th>
                   <th>Price</th>
                   <th>Quantity</th>
                   <th>Total</th>
               </tr>
            </thead>
            <tbody>
                <?php foreach ($basket as $basket_item) { ?>
                    <tr>
                        <?php $total_value += $basket_item["price"] * $basket_item["quantity"]; ?>
                        <td><?php echo $basket_item["name"]; ?></td>
                        <td><?php echo money_format("£%i", $basket_item["price"] / 100); ?></td>
                        <td><?php echo $basket_item["quantity"]; ?></td>
                        <td><?php echo money_format("£%i", $basket_item["price"] * $basket_item["quantity"] / 100); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
       
        <table style="padding-bottom: 50px; border-spacing: 10px;">
            <tr>
                <td style="font-weight: bold;">Total</td> 
                <td><?php echo money_format("£%i", $total_value / 100); ?></td>
            </tr>
            <tr>
                <td style="font-weight: bold;">VAT (20%)</td> 
                <td><?php echo money_format("£%i", $total_value * 0.20 / 100); ?></td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Total + VAT</td> 
                <td><?php echo money_format("£%i", $total_value * 1.20 / 100); ?></td>
            </tr>
        </table>
         
        <form action="checkout.php" method="post">
            <input type="hidden" name="place_order" value="true" />
            <h3>Delivery address</h3>
            
            <p><a href="account.php?action=change_address">Click here</a> to set your default address</p>
            
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
                        <input type="text" name="postcode" value="<?php echo $user["postcode"]; ?>" /><sub>Don't forget the space!</sub>
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
            </div>
            
            <input type="submit" value="Place Order" />
        </form>
    <?php
        } else {
            // Print basket empty message
            echo "<p>Your basket is empty</p>";
        }
    } else {
        // Print login message
        echo "<p>You must <a href=\"login.php\">login</a> in order to view this page</p>";
    }
    
    // Print footer
    require "includes/footer.php";
?>
