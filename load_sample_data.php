<?php
function load_sample_data($db) {
    // Load 100 products
    for ($i = 0; $i < 100; $i++) {
        $product_name = "Product ".($i + 1);
        
        $db->query("INSERT INTO product (name, summary, description, price, usual_price, stock) VALUES
                    (\"$product_name\", \"Summary\", \"Description\", 500, 1000, 0)");
    }
}



    // Load common functions
    require "includes/common.php";
    
    // Initialise password error flag
    $pw_error = false;
    
    // Check if we should load the data
    if ($_POST["action"] == "load_data") {
        // Verify password
        if ($_POST["password"] == "foobar123") {
            load_sample_data($db);
            die("Data loaded. <a href=\"load_sample_data.php\">Go back</a>");
        } else {
            $pw_error = true;
        }
    }
?>

<p>Click the button below to load some sample data</p>

<p>Please make sure that the database is installed first. If not, <a href="install.php">click here</a>.</p>

<p>The password is: foobar123</p>

<br /><br />

<?php if ($pw_error) { ?>
    Invalid Password
<?php } ?>

<form action="load_sample_data.php" method="post">
    <input type="hidden" name="action" value="load_data" />
    Password: <input type="text" name="password" /><br />
    <input type="submit" value="Load sample data" />
</form>
