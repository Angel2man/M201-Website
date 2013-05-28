<?php

function print_breadcrumb($bc) {
    // Initialise first element to true
    $bc_first = true;

    // Loop through breadcrumb elements
    foreach ($bc as $bc_element) {
        // Print seprator if not first element
        if (!$bc_first) {
           echo " &gt;&gt; ";
        }

        // Print element
        $bc_name = $bc_element[0];
        $bc_href = $bc_element[1];
        if ($bc_href) {
            echo "<a href=\"$bc_href\">$bc_name</a>";
        } else {
            echo $bc_name;
        }

        // No longer first element
        $bc_first = false;
    }
}

?>



<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title><?php echo $page["title"]; ?></title>
        <link href="static/style.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div id="container">
            <div id="header">
                <h1>Online Shop</h1>
                <h2>M201 Internet Technology 2 Assignment</h2>
            </div>
            
            <div id="nav">
                <ul>
                    <li><a href="index.php">All Products</a></li>
                    <?php
                        // Get category list
                        $category_list = db_get_category_list($db);
                        
                        // Print out each category in list
                        foreach ($category_list as $category_list_item) {
							echo "<li><a href=\"index.php?cat=".$category_list_item["id"]."\">".$category_list_item["name"]."</a></li>";
						}
                    ?>
                </ul>
                <div style="clear: both;"></div>
            </div>
            
			<?php if ($_SESSION["message"]) { ?>
				<div id="messagebox">
					<?php 
						echo $_SESSION["message"];
						$_SESSION["message"] = "";
					?>
				</div>
			<?php } ?>
            
            <div id="user_info">
                <?php if($user) { ?>
                    Hi, <?php echo $user["username"]; ?>! <a href="logout.php">Logout</a><br />
                    <a href="account.php">Account Settings</a>
                <?php } else { ?>
                    <a href="login.php">Login</a>
                    <a href="register.php">Register</a>
                <?php } ?>
            </div>
            
            <div id="sidebar">
               <?php if (!$user) { ?>
                   <div id="loginbox" class="sidebarbox">
                       <h3>Login</h3> 
                       
                       <div class="sidebarbox_inner">
                           Login form here
                       </div>
                   </div>
               <?php } else { ?>
                   <div id="basketbox" class="sidebarbox">
                       <h3>Basket</h3> 
                       
                       <div class="sidebarbox_inner">
                           <?php if ($user["basket"]) { ?>
                               <ul>
                                   <?php foreach ($user["basket"] as $basket_item) { ?>
                                       <li><?php echo $basket_item["name"]; ?></li>
                                   <?php } ?>
                               </ul>
                           <?php } else { ?>
                               <p>Your basket is empty</p>
                           <?php } ?>
                           <br /><sub><a href="basket.php">View Basket</a> | <a href="checkout.php">Checkout</a></sub>
                       </div>
                   </div>
               <?php } ?>
               <div id="offersbox" class="sidebarbox">
                   <h3>Offers</h3> 
                   
                   <div class="sidebarbox_inner">
                       Offers here
                   </div>
               </div>
            </div>
            
            <div id="content">
                <div id="breadcrumb">
                    <?php if ($page["breadcrumb"]) { print_breadcrumb($page["breadcrumb"]); } ?>
                </div>
                <h2><?php echo $page["title"]; ?></h2> 
