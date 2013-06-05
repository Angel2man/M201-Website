<?php

function db_connect() {
    // http://www.php.net/manual/en/mysqli.quickstart.connections.php
    
    // Database settings
    $db_settings["host"] = "localhost";
    $db_settings["user"] = "shop";
    $db_settings["pass"] = "bsQEq7GFWYb9a4y2";
    $db_settings["name"] = "shop";
    
    // Setup MySQL connection
    $db = new mysqli($db_settings["host"], $db_settings["user"], $db_settings["pass"], $db_settings["name"]);
    
    // Check connection
    if ($db->connect_errno) {
        echo "Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
    }
    
    // DEBUG
    // echo $db->host_info . "\n";
    
    // Return DB
    return $db;
}

function db_get_single($db, $sql) {
	// Run query
	$result = $db->query($sql." LIMIT 1");
	
    // Check that result is not null
    if ($result == null) {
        return null;
    }
    
    // Row count must be 1
    if ($result->num_rows != 1) {
        return null;
    }
    
    // Seek to first row
    $result->data_seek(0);
    
    // Return first row as associated array
    return $result->fetch_assoc();
}

function db_get_array($db, $sql) {
    // Run query
    $result = $db->query($sql);
    
    // Check that result is not null
    if ($result == null) {
        return null;
    }
    
    // Seek first row
    $result->data_seek(0);
    
    // Initialise array
    $array = array();
    
    // Add all rows to array
    while ($row = $result->fetch_assoc()) {
        array_push($array, $row);
    }
    
    // Return
    return $array;
}


function db_get_user_from_username($db, $username, $include_closed) {
    // Add slashes into username
    $username = addslashes($username);
    
	// Convert username to lowercase
	$username = strtolower($username);
	
	// Return
	if ($include_closed) {
		return db_get_single($db, "SELECT * FROM user WHERE loginname=\"$username\"");
	} else {
		return db_get_single($db, "SELECT * FROM user WHERE loginname=\"$username\" AND closed=0");
	}
}

function db_get_user_from_email($db, $email, $include_closed) {
    // Add slashes into email
    $email = addslashes($email);
    
	// Convert email to lowercase
	$email = strtolower($email);
    
	// Return
	if ($include_closed) {
		return db_get_single($db, "SELECT * FROM user WHERE email=\"$email\"");
	} else {
		return db_get_single($db, "SELECT * FROM user WHERE email=\"$email\" AND closed=0");
	}
}

function db_get_user_from_session_id($db, $session_id) {
    // Check that session_id is numeric
    if (!is_numeric($session_id)) {
        return null;
    }
    
    // Query
    return db_get_single($db, "SELECT * FROM session, user WHERE session.id=$session_id AND session.user_id=user.id");
}

function db_get_user_from_id($db, $user_id) {
    // Check that user_id is numeric
    if (!is_numeric($user_id)) {
        return null;
    }
    
    // Query
    return db_get_single($db, "SELECT * FROM user WHERE id=$user_id");
}

function db_get_category_list($db) {
    return db_get_array($db, "SELECT * FROM category ORDER BY position");
}

function db_get_category_from_id($db, $category_id) {
    // Check that category_id is numeric
    if (!is_numeric($category_id)) {
        return null;
    }
    
    // Query
    return db_get_single($db, "SELECT * FROM category WHERE id=$category_id");
}

function db_get_product_list($db, $category_id, $count, $start, $user_id) {
    // Check that count and start are numeric
    if (!is_numeric($count) || !is_numeric($start)) {
        return null;
    }
    
    // Build Query
        $sql = "SELECT * FROM product";
        
        // If user id is set and is numeric, get basket item too
        if ($user_id && is_numeric($user_id)) {
            $sql = $sql." LEFT JOIN basketitem ON basketitem.product_id=product.id AND basketitem.user_id=$user_id";
        }
        
        // If category id is set, only lookup values with that category
        if ($category_id && is_numeric($category_id)) {
            $sql = $sql." WHERE category_id=$category_id";
        }
        
        // Add limit
        $sql = $sql." LIMIT $count OFFSET $start";
    
    // Return array
    return db_get_array($db, $sql);
}

function db_get_product_from_id($db, $product_id, $user_id) {
    // Check that product_id is numeric
    if (!is_numeric($product_id)) {
        return null;
    }
    
    // If user was provided, look for basket item as well
    $sql = null;
    if ($user_id && is_numeric($user_id)) {
    	$sql = "SELECT * FROM product LEFT JOIN basketitem ON basketitem.product_id=product.id AND basketitem.user_id=$user_id WHERE product.id=$product_id";
    } else {
    	$sql = "SELECT * FROM product WHERE id=$product_id";
    }
    
    // Return
    return db_get_single($db, $sql);
}

function db_get_basket_from_user_id($db, $user_id) {
    return db_get_array($db, "SELECT * FROM basketitem INNER JOIN product ON basketitem.product_id=product.id WHERE user_id=$user_id");
}

function db_set_basket_item($db, $user_id, $product_id, $quantity) {
    // Check that user_id, product_id and quantity are all numeric
    if (!is_numeric($user_id) || !is_numeric($product_id) || !is_numeric($quantity)) {
        return;
    }
    
    // If quantity is 0, delete the basket item
    if ($quantity == 0) {
        $db->query("DELETE FROM basketitem WHERE user_id=$user_id AND product_id=$product_id");
    } else {
        $db->query("INSERT INTO basketitem (user_id, product_id, quantity) VALUES ($user_id, $product_id, $quantity)
                    ON DUPLICATE KEY UPDATE quantity=$quantity");
    }
}

function db_place_order($db, $user_id, $shipping_cost, $vat, $name, $address1, $address2, $town, $county, $postcode, $phone) {
    // Check that user_id, shipping_cost and vat are numeric
    if (!is_numeric($user_id) || !is_numeric($shipping_cost) || !is_numeric($vat)) {
        return;
    }
    
    // Add slashes into all address fields
    $name = addslashes($name);
    $address1 = addslashes($address1);
    $address2 = addslashes($address2);
    $town = addslashes($town);
    $county = addslashes($county);
    $postcode = addslashes($postcode);
    $phone = addslashes($phone);
    
    // Since quite a lot is going on, we will need to use MySQL transactions
    // to make sure if there is a problem, the database doesn't get messed up
    
    try {
        // Begin transaction
        $db->autocommit(FALSE);
        
        // Get basket
        $basket = db_get_basket_from_user_id($db, $user_id);
        if (!$basket) {
            return "Basket is empty";
        }
        
        // Calculate value and check stock
        $value = 0;
        foreach ($basket as $basket_item) {
            // Increment value
            $value += $basket_item["quantity"] * $basket_item["price"];
            
            // Check stock
            if ($basket_item["quantity"] > $basket_item["stock"]) {
                return "Not enough stock available for ".$basket_item["name"].". Requested: ".$basket_item["quantity"]." Stock: ".$basket_item["stock"];
            }
        }
        
        // Create order record
        $db->query("INSERT INTO shoporder (user_id, value, shipping_cost, vat, name, address1, address2, town, county, postcode, phone) VALUES
                   ($user_id, $value, $shipping_cost, $vat, \"$name\", \"$address1\", \"$address2\", \"$town\", \"$county\", \"$postcide\", \"$phone\")");
        
        // Get order id
        $order_id = $db->insert_id;
        
        // Create order items for each basket item
        $sql = "INSERT INTO orderitem (order_id, product_id, quantity) VALUES ";
        foreach ($basket as $basket_item) {
            $sql = $sql."($order_id, ".$basket_item["product_id"].", ".$basket_item["quantity"]."),";
        }
        $db->query($sql);
        
        // Reduce stock of each item brought
        foreach ($basket as $basket_item) {
            $db->query("UPDATE product SET stock=stock-".$basket_item["quantity"]." WHERE id=".$basket_item["product_id"]); 
        }
        
        // Remove all products from users basket
        $db->query("DELETE FROM basketitem WHERE user_id=$user_id");
        
        // No errors, commit
        $db->commit();
        
        // Return order number
        return $order_id;
    } catch (Exception $e) {
        // Rollback
        $db->rollback();
        
        // Return database error
        return "Database error";
    }
}

?>
