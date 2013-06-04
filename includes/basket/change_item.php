<?php
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
    
    // Get product
    $product = db_get_product_from_id($db, $product_id, $user["id"]);
    
    // Check that product exists
    if (!$product) {
        forward($next, null);
    }
    
    // Check that the quantity is between 0 and 100 or product stock
    if ($quantity < 0 || $quantity > min($product["stock"], 100)) {
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
?>
