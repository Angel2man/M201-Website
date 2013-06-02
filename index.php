<?php
    // Load common functions
    require "includes/common.php";
    
    // Get page number
    $page_num = $_GET["p"];
    if (!is_numeric($page_num)) {
        $page_num = null;
    }
    if (!$page_num) {
        $page_num = 0;
    }
    
    // Check if we shouldn't print layout
    // We don't print the layout when the user only wants to extend their current list
    $print_layout = !($_GET["layout"] == "none");
    
    // Get category id
    $category_id = $_GET["cat"];
    if (!is_numeric($category_id)) {
        $category_id = null;
    }
    
    // Get category
    $category = null;
    if ($category_id) {
		$category = db_get_category_from_id($db, $category_id);
	}
    
    // Products per page
    $products_per_page = 5;
    
    // Get product list
    $products = db_get_product_list($db, $category["id"], $products_per_page, $page_num * $products_per_page, $user["id"]);
    
    // If were printing the layout
    if ($print_layout) {
		// Set page variables
		if ($category ) {
			$page["title"] = $category["name"];
		} else {
			$page["title"] = "All Products";
		}
		
		// Print header
		require "includes/header.php";
		
		// Start list
		echo "<ul id=\"product_list\">";
		
	}
	
	// Loop through products
	foreach ($products as $product) {
        ?>
            <li>
                <div  class="product_image">
                    <img src="media/product_images/thumbnails/<?php echo $product["image"]; ?>" alt="Product Image" />
                </div>
                
                <h3 class="product_name">
                    <a href="product.php?id=<?php echo $product["id"]; ?>"><?php echo $product["name"]; ?></a>
                </h3>
                
                <p class="product_summary"><?php echo $product["summary"]; ?></p>
                
                <h3 class="product_price">
                    <?php print_price($product["price"], $product["usual_price"]); ?>
                </h3>
                
                <?php
                    // If a user is logged in
                    if ($user) { ?>
                        <form class="product_add_to_basket" action="basket.php?action=change_item" method="post">
                            <input type="hidden" name="product_id" value="<?php echo $product["id"]; ?>" />
                            <input type="hidden" name="quantity" value="+1" />
                            <input type="submit" value="Add to basket" />
                        </form><h3 class="product_in_basket"><sub><?php if ($product["quantity"]) { ?>In basket<?php } ?></sub></h3>
                    <?php }
                ?>
                
                <div style="clear: left;"></div>
            </li>
        <?php
	}
	
	// If were printing the layout
	if ($print_layout) {
		// End list
		echo "</ul>";
		
		// Show more results link
		echo "<div id=\"show_more_results\"><a>Show more results</a></div>";
		
		// Print footer
		require "includes/footer.php";
	}
?>
