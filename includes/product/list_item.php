<li>
    <div  class="product_image">
        <img src="media/product_images/<?php echo $product["image"]; ?>" alt="Product Image" />
    </div>
    
    <h3 class="product_name">
        <a href="product.php?id=<?php echo $product["id"]; ?>"><?php echo $product["name"]; ?></a>
    </h3>
    
    <p class="product_summary"><?php echo $product["summary"]; ?></p>
    
    <h3 class="product_price">
        <?php print_price($product["price"], $product["usual_price"]); ?>
    </h3>

    <h3 class="product_rating"><?php print_stars(5, 3); ?> <sup>(<a href="product.php?id=<?php echo $product["id"]; ?>#reviews">0</a>)</sup></h3>
    
    <?php
        // If a user is logged in
        if ($user) { ?>
            <form class="product_add_to_basket" action="basket.php?action=change_item" method="post">
                <input type="hidden" name="product_id" value="<?php echo $product["id"]; ?>" />
                <input type="hidden" name="quantity" value="+1" />
                <input type="submit" value="Add to basket" />
            </form><h3 class="product_in_basket"><sub><?php if ($product["quantity"]) { ?>In basket<?php } ?></sub></h3>
        <?php } ?>

    <div style="clear: left;"></div>
    
</li>
