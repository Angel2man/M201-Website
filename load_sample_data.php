<?php
    function add_product($db, $name, $summary, $description, $category, $usual_price, $price) {
        
    }
    
    function add_category($db, $name, $position) {
        
    }
    
    function load_sample_data($db) {
        // Categories
        $book_category = add_category($db, "Books", 0);
        $dvd_category = add_category($db, "DVDs", 1);
        $game_category = add_category($db, "Games", 2);
        $music_category = add_category($db, "Music", 3);
        
        // Books
        add_product($db, "OpenGL Programming Guide",
                         "A book about programming with the OpenGL graphics API",
                         "A book about programming with the OpenGL graphics API",
                         $book_category, 2000, 2000);
                         
        add_product($db, "Beginning databases with PostgreSQL",
                         "Matthew, Stones. A book about database development using the PostgreSQL database management system",
                         "A book about database development using the PostgreSQL database management system",
                         $book_category, 1000, 1000);
                         
        add_product($db, "Effective C++",
                         "Scott Meyers. A book for C++ developers to help them improve their skills",
                         "A book for C++ developers to help them improve their skills",
                         $book_category, 500, 500);
                         
        add_product($db, "The Cathedral and the Bazaar",
                         "Eric S. Raymond. Musings on Linux and open source by an accidental revolutionary",
                         "Musings on Linux and open source by an accidental revolutionary",
                         $book_category, 500, 500);
                         
        add_product($db, "Javascript: The Definitive Guide",
                         "David Flanagan. Enormous book about javascript",
                         "Enormous book about javascript",
                         $book_category, 2000, 1500);
                         
        // DVDs
        
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
