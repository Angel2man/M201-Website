<?php
    // This file can be included many times in a single request
    // Make sure that this function doesn't get defined more than once
    if (!$print_stars_defined) {
        function print_stars($total, $on) {
            // Work out how many off stars there are
            $off = $total - $on;
            
            // Loop through on stars
            for ($i = 0; $i < $on; $i++) {
                echo "<img src=\"static/star_on.png\" alt=\"*\" />";
            }
            
            // Loop through off stars
            for ($i = 0; $i < $off; $i++) {
                echo "<img src=\"static/star_off.png\" alt=\"-\" />";
            }
        }
    }
    $print_stars_defined = true;
?>


<h3 class="product_price">
    <?php
        echo money_format("£%i", $product["price"] / 100);
        if ($product["price"] != $product["usual_price"]) {
            echo " <sub style=\"text-decoration: line-through;\">".money_format("£%i", $product["usual_price"] / 100)."</sub> ";
        }
    ?>
</h3>

<h3 class="product_rating"><?php print_stars(5, 3); ?> <sup>(<a href="product.php?id=<?php echo $product["id"]; ?>#ratings">0</a>)</sup></h3>

<div style="clear: left;"></div>
