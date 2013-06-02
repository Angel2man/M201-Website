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
        
        // Check that the quantity is between 0 and 100
        if ($quantity < 0 || $quantity > 100) {
            forward($next, null);
        }
        
        // Get product
        $product = db_get_product_from_id($db, $product_id, $user["id"]);
        
        // Check that product exists
        if (!$product) {
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
?>

<?php require "includes/header.php" ?>

<?php if ($user["basket"]) { ?>
<table style="padding-bottom: 50px; text-align: center; border-spacing: 10px;">
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
		<?php foreach ($user["basket"] as $basket_item) { ?>
			<tr>
				<td>
					<a href="product.php?id=<?php echo $basket_item["product_id"] ?>">
						<?php echo $basket_item["name"]; ?>
					</a>
			   </td>
				<td><?php echo money_format("£%i", $basket_item["price"] / 100); ?></td>
				<td>
					<form action="basket.php?action=change_item" method="post">
						 <input type="hidden" name="product_id" value="<?php echo $basket_item["product_id"]; ?>" />
						 <select name="quantity" onchange="this.form.submit();">
							<?php
								for ($i = 0; $i <= 100; $i++) {
									$extra = "";
									if ($i == $basket_item["quantity"]) {
										$extra = " selected";
									}
									echo "<option value=\"$i\"".$extra.">$i</option>";
								}
							?>
						 </select>
					 </form>
				</td>
				<td><?php echo money_format("£%i",$basket_item["price"] * $basket_item["quantity"] / 100); ?></td>
				<td>
					 <form action="basket.php?action=change_item" method="post">
						 <input type="hidden" name="product_id" value="<?php echo $basket_item["product_id"]; ?>" />
						 <input type="hidden" name="quantity" value="0" />
						 <input type="submit" value="Remove" />
					 </form>
				</td>
			</tr>
		<?php } ?>
	</tbody>
</table>

<h3><a href="checkout.php">Checkout</a></h3>

<?php
	} else {
		// Print basket empty message
		echo "<p>Your basket is empty</p>";
	}
?>

<?php require "includes/footer.php" ?>
