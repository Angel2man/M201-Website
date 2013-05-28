<?php
    function add_product($db, $name, $summary, $description, $category_id, $usual_price, $price) {
        $db->query("INSERT INTO product (name, summary, description, category_id, usual_price, price) VALUES (\"$name\", \"$summary\", \"$description\", $category_id, $usual_price, $price)");
	}
    
    function add_category($db, $name, $position) {
        // Create a new category
		if($db->query("INSERT INTO category (name, position) VALUES (\"$name\", $position)")) {
			// Return new category ID
			return $db->insert_id;
		} else {
			// Return null
			return null;
		}
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
                         $book_category, 1000, 750);
                         
        add_product($db, "Effective C++",
                         "Scott Meyers. A book for C++ developers to help them improve their skills",
                         "A book for C++ developers to help them improve their skills",
                         $book_category, 500, 500);
                         
        add_product($db, "The Cathedral and the Bazaar",
                         "Eric S. Raymond. Musings on Linux and open source by an accidental revolutionary",
                         "Musings on Linux and open source by an accidental revolutionary",
                         $book_category, 500, 500);
                         
        add_product($db, "Javascript: The Definitive Guide",
                         "David Flanagan. Enormous book about Javascript",
                         "Enormous book about Javascript",
                         $book_category, 2000, 1500);
                         
        // DVDs
        add_product($db, "Lord of the Rings: The Two Towers",
                         "",
                         "",
                         $dvd_category, 2000, 1500);
                         
        add_product($db, "The Shawshank Redemption",
                         "",
                         "",
                         $dvd_category, 2000, 1000);
                         
        add_product($db, "The Bourne Identity",
                         "",
                         "",
                         $dvd_category, 2000, 2000);
                         
        add_product($db, "Marley",
                         "A documentary about Bob Marley",
                         "A documentary about Bob Marley",
                         $dvd_category, 2000, 2000);
                         
        add_product($db, "Family Guy Season 3",
                         "",
                         "",
                         $dvd_category, 2000, 2000);
                         
        // Games
        add_product($db, "Battlefield 3",
                         "PC/DVD (Windows)",
                         "",
                         $game_category, 3000, 3000);
                         
        add_product($db, "Halo 3",
                         "Xbox 360",
                         "",
                         $game_category, 3000, 3000);
                         
        add_product($db, "ArmA: Armed Assault",
                         "PC/DVD (Windows)",
                         "",
                         $game_category, 2500, 2500);
                         
        add_product($db, "Far Cry 3",
                         "Xbox 360",
                         "",
                         $game_category, 4000, 4000);
                         
        add_product($db, "Halo: Combat Evolved",
                         "Xbox",
                         "",
                         $game_category, 4000, 4000);
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
