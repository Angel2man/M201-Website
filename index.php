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
    $products_per_page = 20;
    
    // Get product list
    $products = db_get_product_list($db, $category["id"], $products_per_page, $page_num * $products_per_page, $user["id"]);
    
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
    
    // Keep track of product number so we dont accidentally print any more products
    $product_num = 1;
    
    // Loop through products
    foreach ($products as $product) {
        // Dont print any more products if products per page is reached
        if ($product_num > $products_per_page) {
            break;
        }
        
        ?>
			<li>
				<h3>
					<a href="product.php?id=<?php echo $product["id"]; ?>"><?php echo $product["name"]; ?></a>
				</h3>
				<p class="product_summary"><?php echo $product["summary"]; ?></p>
				<h3 class="product_price">
					<?php
						echo money_format("£%i", $product["price"] / 100);
						if ($product["price"] != $product["usual_price"]) {
							echo " <sub style=\"text-decoration: line-through;\">".money_format("£%i", $product["usual_price"] / 100)."</sub> ";
						}
					?>
				</h3>
				
				<form action="basket.php?action=change_item" method="post">
					<input type="hidden" name="product_id" value="<?php echo $product["id"]; ?>" />
					<input type="hidden" name="quantity" value="+1" />
					<input type="submit" value="Add to basket" />
				</form>
				
				<div style="clear: left;"></div>
				
				<hr />
			</li>
        
        <?php
        
        // Increase product number
        $product_num++;
    }
    
    // End list
    echo "</ul>";
    
    // Put previous button if previous page exists
    if ($page_num > 0) {
        echo "<a href=\"index.php?p=".($page_num - 1)."\">&lt;&lt; previous</a>";
    }
    
    // Put next button if next page exists
    if (count($products) > $products_per_page) {
        echo "<a href=\"index.php?p=".($page_num + 1)."\">next &gt;&gt;</a>";
    }
    
    // Print footer
    require "includes/footer.php";
?>
