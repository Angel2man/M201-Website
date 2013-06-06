<?php
    function add_product($db, $name, $summary, $description, $image, $category_id, $usual_price, $price) {
        // Make up a random number for stock
        $stock = rand(0, 100);
        
        $db->query("INSERT INTO product (name, summary, description, image, category_id, usual_price, price, stock) VALUES
                    (\"$name\", \"$summary\", \"$description\", \"$image\", $category_id, $usual_price, $price, $stock)");
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
        
        add_product($db, "OpenGL Programming Guide",
                         "A book about programming with the OpenGL graphics API",
                         "The OpenGL®Programming Guide, Seventh Edition, provides definitive and comprehensive information on OpenGL and the OpenGL Utility Library. The previous edition covered OpenGL through Version 2.1. This seventh edition of the best-selling “red book” describes the latest features of OpenGL Versions 3.0 and 3.1. You will find clear explanations of OpenGL functionality and many basic computer graphics techniques, such as building and rendering 3D models; interactively viewing objects from different perspective points; and using shading, lighting, and texturing effects for greater realism. In addition, this book provides in-depth coverage of advanced techniques, including texture mapping, antialiasing, fog and atmospheric effects, NURBS, image processing, and more. The text also explores other key topics such as enhancing performance, OpenGL extensions, and cross-platform techniques.<br /><br />This description came from <a href=\\\"http://www.amazon.co.uk/dp/0321552628/?tag=hydra0b-21&hvadid=9550947549&ref=asc_df_0321552628#\\\">here</a>",
                         "opengl-pg.jpg",
                         $book_category, 2000, 2000);
                         
        add_product($db, "Beginning databases with PostgreSQL",
                         "Matthew, Stones. A book about database development using the PostgreSQL database management system",
                         "<p>PostgreSQL is arguably the most powerful open-source relational database system. It has grown from academic research beginnings into a functionally-rich, standards-compliant, and enterprise-ready database used by organizations all over the world. And it’s completely free to use.</p><p>Beginning Databases with PostgreSQL offers readers a thorough overview of database basics, starting with an explanation of why you might need to use a database, and following with a summary of what different database types have to offer when compared to alternatives like spreadsheets. You’ll also learn all about relational database design topics such as the SQL query language, and introduce core principles including normalization and referential integrity.</p><p>The book continues with a complete tutorial on PostgreSQL features and functions and include information on database construction and administration. Key features such as transactions, stored procedures and triggers are covered, along with many of the capabilities new to version 8. To help you get started quickly, step-by-step instructions on installing PostgreSQL on Windows and Linux/UNIX systems are included.</p><p>In the remainder of the book, we show you how to make the most of PostgreSQL features in your own applications using a wide range of programming languages, including C, Perl, PHP, Java and C#. Many example programs are presented in the book, and all are available for download from the Apress web site.</p><p>By the end of the book you will be able to install, use, and effectively manage a PostgreSQL server, design and implement a database, and create and deploy your own database applications.</p><p>This description came from <a href=\\\"http://www.amazon.co.uk/Beginning-Databases-PostgreSQL-Novice-Professional/dp/1590594789\\\">here</a></p>",
                         "beginning-databases-postgresql.jpg",
                         $book_category, 1000, 750);
                         
        add_product($db, "Family Guy Season 3",
                         "",
                         "",
                         "family-guy-season-3.jpg",
                         $dvd_category, 2000, 2000);
                         
        add_product($db, "Battlefield 3",
                         "PC/DVD (Windows)",
                         "",
                         "battlefield-3.jpg",
                         $game_category, 3000, 3000);
                         
        add_product($db, "Rammestein: Reise Reise",
                         "",
                         "",
                         "rammestien-reise-reise.jpg",
                         $music_category, 1000, 1000);
                         
        add_product($db, "Javascript: The Definitive Guide",
                         "David Flanagan. Enormous book about Javascript",
                         "Enormous book about Javascript",
                         "javascript-definitive-guide.jpg",
                         $book_category, 2000, 1500);
                         
        add_product($db, "Experience Hendrix: The best of Jimi Hendrix",
                         "A Jimi Hendrix compilation",
                         "",
                         "experience-hendrix.jpg",
                         $music_category, 1000, 1000);
                         
        add_product($db, "Halo: Combat Evolved",
                         "Xbox",
                         "",
                         "halo-combat-evolved.jpg",
                         $game_category, 4000, 4000);
                         
        add_product($db, "Led Zeppelin Mothership",
                         "A Led Zeppelin Compliation",
                         "",
                         "led-zeppelin-mothership.jpg",
                         $music_category, 1000, 1000);
                         
        add_product($db, "Halo 3",
                         "Xbox 360",
                         "",
                         "halo-3.jpg",
                         $game_category, 3000, 3000);
                         
        add_product($db, "The Cathedral and the Bazaar",
                         "Eric S. Raymond. Musings on Linux and open source by an accidental revolutionary",
                         "Musings on Linux and open source by an accidental revolutionary",
                         "cathedral-bazaar.jpg",
                         $book_category, 500, 500);
                         
        add_product($db, "Iron Maiden: The Trooper",
                         "",
                         "",
                         "iron-maiden-the-trooper.jpg",
                         $music_category, 1000, 1000);
                         
        add_product($db, "ArmA: Armed Assault",
                         "PC/DVD (Windows)",
                         "",
                         "arma-armed-assault.jpg",
                         $game_category, 2500, 2500);
                         
        add_product($db, "Lord of the Rings: The Two Towers",
                         "",
                         "",
                         "lotr-two-towers.jpg",
                         $dvd_category, 2000, 1500);
                         
        add_product($db, "Far Cry 3",
                         "Xbox 360",
                         "",
                         "far-cry-3.jpg",
                         $game_category, 4000, 4000);
                         
        add_product($db, "Marley",
                         "A documentary about Bob Marley",
                         "A documentary about Bob Marley",
                         "marley.jpg",
                         $dvd_category, 2000, 2000);
                         
        add_product($db, "Bob Marley: Legend",
                         "A Bob Marley compilation",
                         "",
                         "bob-marley-legend.jpg",
                         $music_category, 1000, 1000);
                         
        add_product($db, "The Shawshank Redemption",
                         "",
                         "",
                         "shawshank-redemption.jpg",
                         $dvd_category, 2000, 1000);
                         
        add_product($db, "Effective C++",
                         "Scott Meyers. A book for C++ developers to help them improve their skills",
                         "A book for C++ developers to help them improve their skills",
                         "effective-cpp.jpg",
                         $book_category, 500, 500);
                         
        add_product($db, "The Bourne Identity",
                         "",
                         "",
                         "bourne-identity.jpg",
                         $dvd_category, 2000, 2000);
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
<br /><br />

<?php if ($pw_error) { ?>
    Invalid Password
<?php } ?>

<form action="load_sample_data.php" method="post">
    <input type="hidden" name="action" value="load_data" />
    Password: <input type="text" name="password" /><br />
    <input type="submit" value="Load sample data" />
</form>
