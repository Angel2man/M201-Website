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
        <link href="/static/style.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div id="container">
            <div id="header">
                <h1>Online Shop</h1>
                <h2>M201 Internet Technology 2 Assignment</h2>
            </div>
            
            <div id="nav">
                <ul>
                    <li><a href="/index.php">Products</a></li>
                    <li><a href="/account.php">Account Settings</a></li>
                    <li><a href="/basket.php">Basket</a></li>
                    <?php if ($user) { ?>
                        <li><a href="/logout.php">Logout</a></li>
                    <?php } else { ?>
                        <li><a href="/login.php">Login</a></li>
                    <?php } ?>
                </ul>
            </div>
            <div style"clear: both;"></div>
            
            <div id="sidebar">
               <?php if (!$user) { ?>
                   <div id="loginbox" class="sidebarbox">
                       <h3>Login</h3> 
                       
                       <div class="sidebarbox_inner">
                           Login form here
                       </div>
                   </div>
               <?php } else { ?>
                   <div id="user_info">
                       Hi, <?php echo $user["username"]; ?>! <a href="/logout.php">Logout</a>
                   </div>
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
                           <br /><sub><a href="/basket.php">View Basket</a> | <a href="/checkout.php">Checkout</a></sub>
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
