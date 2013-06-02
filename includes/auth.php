<?php

function auth_get_user_id_from_credentials($db, $username, $password) {
    // Convert username to lowercase
    $username = strtolower($username);
    
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
    // Set logged out flag on session
    $db->query("UPDATE session SET logged_out=1 WHERE id=$session_id");
}


function auth_check_username_exist($db, $username) {
    return db_get_user_from_username($db, $username, true) != null;
}


function auth_check_email_exist($db, $email) {
    return db_get_user_from_username($db, $email, true) != null;
}


function auth_register($db, $username, $email, $password) {
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
    // Reset verification email sent flag
    $db->query("UPDATE user SET verification_email_sent=0 WHERE id=$user_id");
}


function auth_change_password($db, $user_id, $password) {
    // Create a salt
    $password_salt = crypt_new_salt();
    
    // Get md5 hash of password
    $password_hash = crypt_get_hash($password, $password_salt);
    
    // Set password
    $db->query("UPDATE user SET password_hash=\"$password_hash\", password_salt=\"$password_salt\" WHERE id=$user_id");
}


function auth_change_address($db, $user_id, $name, $address1, $address2, $town, $county, $postcode, $phone) {
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
    // Set account closed flag
    $db->query("UPDATE user SET closed=1 WHERE id=$user_id");
}

?>
