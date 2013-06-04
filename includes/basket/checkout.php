<table>
    <thead>
       <tr>
           <th>Product</th>
           <th>Price</th> 
           <th>Quantity</th>
           <th>Total</th>
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
                <td><?php echo $basket_item["quantity"]; ?></td>
                <td><?php echo money_format("£%i",$basket_item["price"] * $basket_item["quantity"] / 100); ?></td>
            </tr>
        <?php } ?>
        <tr>
            <?php $total_value += 500; ?>
            <td>Shipping</td>
            <td>£5</td>
            <td>1</td>
            <td>£5</td>
        </tr>
    </tbody>
</table>


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

<form action="basket.php?action=checkout" method="post">
    <h3>Delivery address</h3>
    
    <p><a href="account.php?action=change_address">Click here</a> to set your default address</p>
    
    <div class="form">
        <div class="form_row">
            <div class="form_label">Name</div>
            <div class="form_field">
                <input type="text" name="name" value="<?php echo $name; ?>" />
                <div class="form_error"><?php if ($name_error) { echo $name_error; } ?></div>
            </div>
        </div>
        <div class="form_row">
            <div class="form_label">Address 1</div>
            <div class="form_field">
                <input type="text" name="address1" value="<?php echo $address1; ?>" />
                <div class="form_error"><?php if ($address1_error) { echo $address1_error; } ?></div>
            </div>
        </div>
        <div class="form_row">
            <div class="form_label">Address 2</div>
            <div class="form_field">
                <input type="text" name="address2" value="<?php echo $address2; ?>" />
                <div class="form_error"><?php if ($address2_error) { echo $address2_error; } ?></div>
            </div>
        </div>
        <div class="form_row">
            <div class="form_label">Town/City</div>
            <div class="form_field">
                <input type="text" name="town" value="<?php echo $town; ?>" />
                <div class="form_error"><?php if ($town_error) { echo $town_error; } ?></div>
            </div>
        </div>
        <div class="form_row">
            <div class="form_label">County</div>
            <div class="form_field">
                <input type="text" name="county" value="<?php echo $county; ?>" />
                <div class="form_error"><?php if ($county_error) { echo $county_error; } ?></div>
            </div>
        </div>
        <div class="form_row">
            <div class="form_label">Postcode</div>
            <div class="form_field">
                <input type="text" name="postcode" value="<?php echo $postcode; ?>" /><sub>Don't forget the space!</sub>
                <div class="form_error"><?php if ($postcode_error) { echo $postcode_error; } ?></div>
            </div>
        </div>
        <div class="form_row">
            <div class="form_label">Phone</div>
            <div class="form_field">
                <input type="text" name="phone" value="<?php echo $phone; ?>" />
                <div class="form_error"><?php if ($phone_error) { echo $phone_error; } ?></div>
            </div>
        </div>
        <div class="form_row">
            <div class="form_label">Phone</div>
            <div class="form_field">
                <input type="text" name="phone" value="<?php echo $phone; ?>" onkeyup="validate_address_form(this.form);" />
                <div class="form_error"><?php if ($phone_error) { echo $phone_error; } ?></div>
            </div>
        </div>
    </div>
    
    <input type="submit" value="Place Order" />
</form>
