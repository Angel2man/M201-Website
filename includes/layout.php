<?php

function layout_print_breadcrumb($bc) {
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
