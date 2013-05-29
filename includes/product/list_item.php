<li>
    <h3 class="product_name">
        <a href="product.php?id=<?php echo $product["id"]; ?>"><?php echo $product["name"]; ?></a>
    </h3>
    
    <p class="product_summary"><?php echo $product["summary"]; ?></p>
    
    <?php require "includes/product/price_and_rating.php"; ?>
    
    <hr />
</li>
