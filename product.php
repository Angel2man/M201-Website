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
?>

    
    <div style="float: left; padding-right: 20px;"><h4>
        <?php if ($product["price"] != $product["usual_price"]) {
            echo "<sub style=\"text-decoration: line-through;\">".money_format("£%i", $product["usual_price"] / 100)."</sub> ";
        }
        echo money_format("£%i", $product["price"] / 100);
        ?>
    </h4></div>
    
    <form action="basket.php?action=change_item" method="post">
        <input type="hidden" name="product_id" value="<?php echo $product["id"]; ?>" />
        <input type="hidden" name="quantity" value="+1" />
        <input type="submit" value="Add to basket" />
    </form>
    
    <h3 style="clear: left; padding-top: 20px;">Product description</h3>
    <p><?php echo $product["description"]; ?></p>
    
    <h3>Reviews and comments</h3>
    
    
<?php
    }
    
    // Print footer
    require "includes/footer.php";
?>
