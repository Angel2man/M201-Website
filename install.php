<?php
    function install_db($db) {
        // Drop tables
        // NOTE: Tables are deleted in reverse order to make sure foreign key constraints are removed properly
        $db->query("DROP TABLE IF EXISTS orderitem");
        $db->query("DROP TABLE IF EXISTS basketitem");
        $db->query("DROP TABLE IF EXISTS shoporder");
        $db->query("DROP TABLE IF EXISTS session");
        $db->query("DROP TABLE IF EXISTS user");
        $db->query("DROP TABLE IF EXISTS product");
        $db->query("DROP TABLE IF EXISTS category");
        
        // Product table
        $db->query("CREATE TABLE category (
                        id        int(11)  NOT NULL  AUTO_INCREMENT,
                        name      text     NOT NULL,
                        position  int(11)  NOT NULL  DEFAULT 0,
                        
                        PRIMARY KEY (id)
                    ) ENGINE = InnoDB;");
        
        // Product table
        $db->query("CREATE TABLE product (
                        id           int(11)       NOT NULL  AUTO_INCREMENT,
                        name         text          NOT NULL,
                        summary      text          NOT NULL  DEFAULT '',
                        category_id  int(11),
                        description  text          NOT NULL  DEFAULT '',
                        image        varchar(256)  NOT NULL  DEFAULT 'nopic.png',
                        price        int(11)       NOT NULL  DEFAULT 0,
                        usual_price  int(11)       NOT NULL  DEFAULT 0,
                        stock        int(11)       NOT NULL  DEFAULT 0,
                        
                        PRIMARY KEY (id),
                        FOREIGN KEY (category_id) REFERENCES category(id)
                    ) ENGINE = InnoDB;");
        
        // User table
        $db->query("CREATE TABLE user (
                        id             int(11)       NOT NULL  AUTO_INCREMENT,
                        loginname      varchar(256)  NOT NULL,
                        username       varchar(256)  NOT NULL,
                        email          varchar(256)  NOT NULL,
                        password_hash  varchar(32)  NOT NULL,
                        password_salt  varchar(32)  NOT NULL,
                        name           varchar(256)  NOT NULL  DEFAULT '',
                        address1       varchar(256)  NOT NULL  DEFAULT '',
                        address2       varchar(256)  NOT NULL  DEFAULT '',
                        town           varchar(256)  NOT NULL  DEFAULT '',
                        county         varchar(256)  NOT NULL  DEFAULT '',
                        postcode       varchar(10)   NOT NULL  DEFAULT '',
                        phone          varchar(20)   NOT NULL  DEFAULT '',
                        closed         tinyint(1)    NOT NULL  DEFAULT 0,
                        verification_email_sent  tinyint(1)  NOT NULL  DEFAULT 0,
                        email_verified  tinyint(1)  NOT NULL  DEFAULT 0,
                        email_verification_key  varchar(256)  DEFAULT NULL,
                        
                        PRIMARY KEY (id),
                        UNIQUE KEY loginname (loginname),
                        UNIQUE KEY email (email)
                    ) ENGINE = InnoDB;");
        
        // Session table
        $db->query("CREATE TABLE session (
                        id          int(11)       NOT NULL  AUTO_INCREMENT,
                        user_id     int(11)       NOT NULL,
                        login_time  datetime      NOT NULL,
                        ip          varchar(256)  NOT NULL,
                        logged_out  tinyint(1)    NOT NULL  DEFAULT 0,
                        
                        PRIMARY KEY (id),
                        FOREIGN KEY (user_id) REFERENCES user(id)
                    ) ENGINE = InnoDB;");
        
        // Order table
        // Named "shoporder" as mysql doesn't like the name "order"
        $db->query("CREATE TABLE shoporder (
                        id          int(11)       NOT NULL  AUTO_INCREMENT,
                        user_id     int(11)       NOT NULL,
                        value       int(11)       NOT NULL,
                        shipping_cost  int(11)    NOT NULL,
                        vat         float         NOT NULL,
                        name        varchar(256)  NOT NULL  DEFAULT '',
                        address1    varchar(256)  NOT NULL  DEFAULT '',
                        address2    varchar(256)  NOT NULL  DEFAULT '',
                        town        varchar(256)  NOT NULL  DEFAULT '',
                        county      varchar(256)  NOT NULL  DEFAULT '',
                        postcode    varchar(10)   NOT NULL  DEFAULT '',
                        phone       varchar(20)   NOT NULL  DEFAULT '',
                        paid        tinyint(1)    NOT NULL  DEFAULT 0,
                        dispatched  tinyint(1)    NOT NULL  DEFAULT 0,
                        canceled    tinyint(1)    NOT NULL  DEFAULT 0,
                        
                        PRIMARY KEY (id),
                        FOREIGN KEY (user_id) REFERENCES user(id)
                    ) ENGINE = InnoDB;");
        
        // Order item table
        $db->query("CREATE TABLE orderitem (
                        order_id    int(11)  NOT NULL,
                        product_id  int(11)  NOT NULL,
                        quantity    int(11)  NOT NULL,
                        
                        PRIMARY KEY (order_id, product_id),
                        FOREIGN KEY (order_id) REFERENCES shoporder(id),
                        FOREIGN KEY (product_id) REFERENCES product(id)
                    ) ENGINE = InnoDB;");
        
        // Basket item table
        $db->query("CREATE TABLE basketitem (
                        user_id     int(11)  NOT NULL,
                        product_id  int(11)  NOT NULL,
                        quantity    int(11)  NOT NULL,
                        
                        PRIMARY KEY (user_id, product_id),
                        FOREIGN KEY (user_id) REFERENCES user(id),
                        FOREIGN KEY (product_id) REFERENCES product(id)
                    ) ENGINE = InnoDB;");
        
    }
    
    
    
    
    // Load common functions
    require "includes/common.php";
    
    // Initialise password error flag
    $pw_error = false;
    
    // Check if we should install
    if ($_POST["action"] == "install_db") {
        // Verify password
        if ($_POST["password"] == "foobar123") {
            install_db($db);
            die("Database installed. You can now <a href=\"load_sample_data.php\">load some sample data</a><br/><a href=\"install.php\">Go back</a>");
        } else {
            $pw_error = true;
        }
    }
?>

<p>Click the button below to install a fresh new database</p>
<p>This will delete any data already in the database</p>
<p>To change database settings, look in includes/db.php</p>
<br /><br />

<?php if ($pw_error) { ?>
    Invalid Password
<?php } ?>

<form action="install.php" method="post">
    <input type="hidden" name="action" value="install_db" />
    Password: <input type="text" name="password" /><br />
    <input type="submit" value="Install Database" />
</form>
