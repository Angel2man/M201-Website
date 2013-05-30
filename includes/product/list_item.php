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
    
    <?php if ($product["quantity"]) { ?><h3 class="product_in_basket">In basket</h3><?php } ?>

    <div style="clear: left;"></div>
    
</li>
