<?php

function db_connect() {
    // http://www.php.net/manual/en/mysqli.quickstart.connections.php
    
    // Database settings
    $db_settings["host"] = "10.0.125.28";
    $db_settings["user"] = "shop2";
    $db_settings["pass"] = "W8GeeMu3vZGs2pJc";
    $db_settings["name"] = "shop2";
    
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


function db_get_user_from_session_id($db, $session_id) {
    // Query
    $result = $db->query("SELECT * FROM session, user WHERE session.id = $session_id  AND session.user_id = user.id LIMIT 1");
    
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

function db_get_product_list($db, $category_id, $count, $start, $user_id) {
    // Note: An extra row is fetched from the database here. This is not displayed
    // anywhere but is used as a simple way to work out if there is a next page
    $count++;
    
    // Query
    $sql = "SELECT * FROM product";
    
    // If user id is set, get basket item too
    if ($user_id) {
        $sql = $sql." LEFT JOIN basketitem ON basketitem.product_id=product.id AND basketitem.user_id=$user_id";
    }
    
    // If category id is set, only lookup values with that category
    if ($category_id) {
        $sql = $sql." WHERE category_id=$category_id";
    }
    
    // Add limit
    $sql = $sql." LIMIT $count OFFSET $start";
    
    // Run query
    $result = $db->query($sql);
    
    // Check that result is not null
    if ($result == null) {
        return null;
    }
    
    // Seek first row
    $result->data_seek(0);
    
    // Initialise array
    $products = array();
    
    // Add all rows to array
    while ($row = $result->fetch_assoc()) {
        // Add product
        array_push($products, $row);
    }
    
    // Return products
    return $products;
}


function db_get_product_from_id($db, $product_id, $user_id) {
    // If user was provided, look for basket item as well
    $result = null;
    if ($user_id) {
    	$result = $db->query("SELECT * FROM product LEFT JOIN basketitem ON basketitem.product_id=product.id AND basketitem.user_id=$user_id WHERE product.id=$product_id LIMIT 1");
    } else {
    	$result = $db->query("SELECT * FROM product WHERE id = \"$product_id\" LIMIT 1");
    }
    
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


function db_get_reviews_from_product_id($db, $product_id) {
    return array();
}


function db_get_basket_from_user_id($db, $user_id) {
    // Query
    $result = $db->query("SELECT * FROM basketitem INNER JOIN product ON basketitem.product_id=product.id WHERE user_id=$user_id");
    
    // Check that result is not null
    if ($result == null) {
        return null;
    }
    
    // Seek first row
    $result->data_seek(0);
    
    // Initialise array
    $basket = array();
    
    // Add all rows to array
    while ($row = $result->fetch_assoc()) {
        // Add basket item
        array_push($basket, $row);
    }
    
    // Return basket
    return $basket;
}


?>
