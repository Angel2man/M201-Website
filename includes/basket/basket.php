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

<h3><a href="basket.php?action=checkout">Checkout</a></h3>
