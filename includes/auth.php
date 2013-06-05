<?php

function auth_get_user_id_from_credentials($db, $username, $password) {
    // Check if username is an email and query the database
    $user = null;
    if (strpos($username, "@") != false) {
        $user = db_get_user_from_email($db, $username, false);
    } else {
        $user = db_get_user_from_username($db, $username, false);
    }
    
    // Verify password
    if ($user["password_hash"] != crypt_get_hash($password, $user["password_salt"])) {
        return null;
    }
    
    // Return user id
    return $user["id"];
}


function auth_login($db, $user_id, $ip) {
    // Check that user_id is numeric
    if (!is_numeric($user_id)) {
        return null;
    }
    
    // Add slashes into ip
    $ip = addslashes($ip);
    
    // Get current date
    $date = date("Y-m-d H-i-s");
    
    // Create a new session
    if($db->query("INSERT INTO session (user_id, login_time, ip) VALUES ($user_id, \"$date\", \"$ip\")")) {
        // Return new session ID
        return $db->insert_id;
    } else {
        // Return null
        return null;
    }
}


function auth_logout($db, $session_id) {
    // Check that session_id is numeric
    if (!is_numeric($session_id)) {
        return null;
    }
    
    // Set logged out flag on session
    $db->query("UPDATE session SET logged_out=1 WHERE id=$session_id");
}


function auth_check_username_exist($db, $username) {
    // Add slashes into username
    $username = addslashes($username);
    
    // If user was found, return true
    return !!db_get_user_from_username($db, $username, true);
}


function auth_check_email_exist($db, $email) {
    // Add slashes into email
    $email = addslashes($email);
    
    // If user was found, return true
    return !!db_get_user_from_email($db, $email, true);
}


function auth_register($db, $username, $email, $password) {
    // Add slashes into username and email
    // We will not add slashes into password as that is encrypted before
    // being put in SQL
    $username = addslashes($username);
    $email = addslashes($email);
    
    // Create loginname
    $loginname = strtolower($username);
    
    // Make email lowercase
    $email = strtolower($email);
    
    // Create a salt
    $password_salt = crypt_new_salt();
    
    // Get md5 hash of password
    $password_hash = crypt_get_hash($password, $password_salt);
    
    // Generate verification key
    $verification_key = md5(uniqid($username, true));
    
    // Create a new user
    if($db->query("INSERT INTO user (loginname, username, email, password_hash, password_salt, email_verification_key) VALUES
                   (\"$loginname\", \"$username\", \"$email\", \"$password_hash\", \"$password_salt\", \"$verification_key\")")) {
        // Return new user ID
        return $db->insert_id;
    } else {
        // Return null
        return null;
    }
}


function auth_verify_email($db, $key) {
    // Add slashes into key
    $key = addslashes($key);
    
    // Query
    if ($db->query("UPDATE user SET email_verified=1 WHERE email_verification_key=\"$key\"")) {
        // Return true if affected rows is greater than zero
        return $db->affected_rows > 0;
    } else {
        // Didn't succeed
        return false;
    }
}


function auth_resend_verification_email($db, $user_id) {
    // Check that user_id is numeric
    if (!is_numeric($user_id)) {
        return;
    }
    
    // Reset verification email sent flag
    $db->query("UPDATE user SET verification_email_sent=0 WHERE id=$user_id");
}


function auth_change_password($db, $user_id, $password) {
    // Check that user_id is numeric
    if (!is_numeric($user_id)) {
        return;
    }
    
    // No slashes will be added into password as it is encrypted before
    // being put in the SQL query
    
    // Create a salt
    $password_salt = crypt_new_salt();
    
    // Get md5 hash of password
    $password_hash = crypt_get_hash($password, $password_salt);
    
    // Set password
    $db->query("UPDATE user SET password_hash=\"$password_hash\", password_salt=\"$password_salt\" WHERE id=$user_id");
}


function auth_change_address($db, $user_id, $name, $address1, $address2, $town, $county, $postcode, $phone) {
    // Check that user_id is numeric
    if (!is_numeric($user_id)) {
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
    
    // Set address
    $db->query("UPDATE user SET
                name=\"$name\",
                address1=\"$address1\",
                address2=\"$address2\",
                town=\"$town\",
                county=\"$county\",
                postcode=\"$postcode\",
                phone=\"$phone\"
                WHERE id=$user_id");
}


function auth_close_account($db, $user_id) {
    // Check that user_id is numeric
    if (!is_numeric($user_id)) {
        return;
    }
    
    // Set account closed flag
    $db->query("UPDATE user SET closed=1 WHERE id=$user_id");
}

?>
