<?php
    // Load common functions
    require "includes/common.php";
    
    // Check if user is not logged in
    if (!$user) {
        // Forward user to login page with next parameter set to this page
        forward("login.php?next=basket.php", null);
    }
    
    // Check if were changing a basket item
    if ($_GET["action"] == "change_item") {
        // Get next
        $next = $_GET["next"];
        if (!$next) {
            $next = "basket.php";
        }
        
        // Make sure the client is posting
        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            forward($next, null);
        }
        
        // Get product id
        $product_id = $_POST["product_id"];
        if (!is_numeric($product_id)) {
            $product_id == null;
        }
        
        // Get quantity
        $quantity = $_POST["quantity"];
        if (!is_numeric($quantity)) {
            $quantity == null;
        }
        
        // Check that both values have been set
        if (!$product_id || $quantity == null) {
            forward($next, null);
        }
        
        // Get product
        $product = db_get_product_from_id($db, $product_id, $user["id"]);
        
        // Check that product exists
        if (!$product) {
            forward($next, null);
        }
        
        // Check that the quantity is between 0 and 100 or product stock
        if ($quantity < 0 || $quantity > min($product["stock"], 100)) {
            forward($next, null);
        }
        
        // Get current quantity
        $current_quantity = 0;
        if ($product["quantity"]) {
            $current_quantity = $product["quantity"];
        }
        
        // Make sure quantity has changed
        if ($quantity == $current_quantity) {
            forward($next, null);
        }
        
        // Add to basket
        db_set_basket_item($db, $user["id"], $product_id, $quantity);
        
        // Forward and print message
        if ($quantity > $current_quantity) {
            forward($next, "Added ".$product["name"]." to your basket");
        } else {
            forward($next, "Removed ".$product["name"]." from your basket");
        }
    }
    
    // Set page variables
    $page["title"] = "Basket";
    
    // Check if were checking out
    $checkout = false;
    if ($_GET["action"] == "checkout") {
        // Change title to checkout
        $page["title"] = "Checkout";
        
        // Add some breadcrumb
        $page["breadcrumb"] = array(
            array("Basket", "basket.php"),
            array("Checkout", null)
        );
        
        // Set checkout flag
        $checkout = true;
    }
?>

<?php require "includes/header.php" ?>

<?php if ($user["basket"]) { ?>

    <table>
        <thead>
           <tr>
               <th>Product</th>
               <th>Price</th> 
               <th>Quantity</th>
               <th>Total</th>
               <th></th>
           </tr>
        </thead>
        <tbody>
            <?php
            // Initialise total value
            $total_value = 0;
            
            // Loop through basket
            foreach ($user["basket"] as $basket_item) {
                // Increment total value
                $total_value += $basket_item["price"] * $basket_item["quantity"]; ?>
                
                <tr>
                    <td>
                        <a href="product.php?id=<?php echo $basket_item["product_id"] ?>">
                            <?php echo $basket_item["name"]; ?>
                        </a>
                   </td>
                    <td><?php echo money_format("£%i", $basket_item["price"] / 100); ?></td>
                    <td>
                        <?php if ($checkout) {
                            echo $basket_item["quantity"];
                        } else { ?>
                            <form action="basket.php?action=change_item" method="post">
                                 <input type="hidden" name="product_id" value="<?php echo $basket_item["product_id"]; ?>" />
                                 <select name="quantity" onchange="this.form.submit();">
                                    <?php
                                        for ($i = 1; $i <= min(100, $basket_item["stock"]); $i++) {
                                            $extra = "";
                                            if ($i == $basket_item["quantity"]) {
                                                $extra = " selected";
                                            }
                                            echo "<option value=\"$i\"".$extra.">$i</option>";
                                        }
                                    ?>
                                 </select>
                             </form>
                         <?php } ?>
                    </td>
                    <td><?php echo money_format("£%i",$basket_item["price"] * $basket_item["quantity"] / 100); ?></td>
                    <td>
                        <?php if (!$checkout) { ?>
                             <form action="basket.php?action=change_item" method="post">
                                 <input type="hidden" name="product_id" value="<?php echo $basket_item["product_id"]; ?>" />
                                 <input type="hidden" name="quantity" value="0" />
                                 <input type="submit" value="Remove" />
                             </form>
                         <?php } ?>
                    </td>
                </tr>
            <?php } ?>
            
            <?php // If were checking out, add shipping
            if ($checkout) { ?>
                   
                <tr>
                    <?php $total_value += 500; ?>
                    <td>Shipping</td>
                    <td>£5</td>
                    <td>1</td>
                    <td>£5</td>
                    <td></td>
                </tr>
                
            <?php } ?>
        </tbody>
    </table>

    <?php if ($checkout) { ?>
    
        <table>
            <tr>
                <th>Total</th> 
                <td><?php echo money_format("£%i", $total_value / 100); ?></td>
            </tr>
            <tr>
                <th>VAT (20%)</th> 
                <td><?php echo money_format("£%i", $total_value * 0.20 / 100); ?></td>
            </tr>
            <tr>
                <th>Total + VAT</th> 
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
    <?php } else { ?>
        <h3><a href="basket.php?action=checkout">Checkout</a></h3>
    <?php } ?>

<?php
	} else {
		// Print basket empty message
		echo "<p>Your basket is empty</p>";
	}
?>

<?php require "includes/footer.php" ?>
