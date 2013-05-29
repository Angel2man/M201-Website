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
		require "includes/product/list_item.php";
	}
	
	// If were printing the layout
	if ($print_layout) {
		// End list
		echo "</ul>";
		
		// Show more results link
		echo "<div style=\"text-align: center;\"><a>Show more results</a></div>";
		
		// Print footer
		require "includes/footer.php";
	}
?>
