<?php
    // Load common functions
    require "includes/common.php";
    
    // Check if user is not logged in
    if (!$user) {
        // Forward user to login page with next parameter set to this page
        header("Location: login.php?next=basket.php");
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
