<?php
    // Load common functions
    require "includes/common.php";
    
    // Get product id
    $product_id = $_GET["id"];
    
    // Get product if product id is a number
    $product = null;
    if (is_numeric($product_id)) {
        $product = db_get_product_from_id($db, $product_id, $user["id"]);
    }
    
    // Initialise error flag
    $error = false;
    
    // Check if product exists
    if ($product) {
        // Breadcrumb
        $page["breadcrumb"] = array(
            array("Products", "index.php"),
            array($product["name"], null)
        );
        
        // Title
        $page["title"] = $product["name"];
    } else { // Error
        // Title
        $page["title"] = "Couldn't find product";;
        
        // Set error flag
        $error = true;
    }
    
    
    
    
    
    // Print header
    require "includes/header.php";
    
    // Check for error
    if ($error) {
        // Print error message
        echo "<p><a href=\"index.php\">Click here</a> to go back to the product page</p>";
    } else {
        // Product image, price and rating\
        ?>
        
        <div class="product_image">
            <img src="media/product_images/<?php echo $product["image"]?>" alt="Product Image" />
        </div>
        
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
            <?php } else {
                echo "<h4 class=\"product_add_to_basket\">Please <a href=\"login.php?next=product.php?id=".$product["id"]."\">login</a> to add this item to your basket</h4>";
            }
        ?>
        
        <h3 style="clear: left; padding-top: 40px;">Product description</h3>
        <p><?php echo $product["description"]; ?></p>
        <h3 style="padding-top: 40px;">Reviews</h3>
        <p>No reviews</p>
        
        <h3 style="padding-top: 20px;">Leave a review</h3>
        
        <?php
        // If user is logged in
        if ($user) {
            // Display review form
            require "includes/product/review_form.php";
        } else {
            // Display login message
            echo "<h4>Please <a href=\"login.php?next=product.php?id=".$product["id"]."\">login</a> to leave a review</h4>";
        }
    }
    
    // Print footer
    require "includes/footer.php";
?>
