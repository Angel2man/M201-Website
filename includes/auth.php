<?php

function auth_get_user_id_from_credentials($db, $username, $password) {
    // Convert username to lowercase
    $username = strtolower($username);
    
    // Check if username is an email and query the database
    $result = null;
    if (strpos($username, "@") != false) {
        $result = $db->query("SELECT id, password FROM user WHERE email=\"$username\" AND closed=0 LIMIT 1");
    } else {
        $result = $db->query("SELECT id, password FROM user WHERE loginname=\"$username\" AND closed=0 LIMIT 1");
    }
    
    // Check that result is not null
    if ($result == null) {
        return null;
    }
    
    // Row count must be 1
    if ($result->num_rows != 1) {
        return null;
    }
    
    // Seek to first row
    $result->data_seek(0);
    
    // Get the user details
    $user = $result->fetch_assoc();
    
    // Verify password
    if ($user["password"] != md5($password)) {
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
    // Query the database
    $result = $db->query("SELECT id FROM user WHERE username=\"$username\" LIMIT 1");
    
    // Check that result is not null
    if ($result == null) {
        return false;
    }
    
    // Row count must be 1
    if ($result->num_rows != 1) {
        return false;
    }
    
    // Username exists
    return true;
}


function auth_check_email_exist($db, $email) {
    // Query the database
    $result = $db->query("SELECT id FROM user WHERE email=\"$email\" LIMIT 1");
    
    // Check that result is not null
    if ($result == null) {
        return false;
    }
    
    // Row count must be 1
    if ($result->num_rows != 1) {
        return false;
    }
    
    // Email exists
    return true;
}


function auth_register($db, $username, $email, $password) {
    // Create loginname
    $loginname = strtolower($username);
    
    // Make email lowercase
    $email = strtolower($email);
    
    // Get md5 hash of password
    $password_md5 = md5($password);
    
    // Generate verification key
    $verification_key = md5(uniqid($username, true));
    
    // Create a new user
    if($db->query("INSERT INTO user (loginname, username, email, password, email_verification_key) VALUES (\"$loginname\", \"$username\", \"$email\", \"$password_md5\", \"$verification_key\")")) {
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
    // Get md5 hash of password
    $password_md5 = md5($password);
    
    // Set password
    $db->query("UPDATE user SET password=\"$password_md5\" WHERE id=$user_id");
}


function auth_change_address($db, $user_id, $address1, $address2, $street, $town, $county, $postcode, $phone) {
    // Set address
    $db->query("UPDATE user SET
                address1=\"$address1\"
                address2=\"$address2\"
                street=\"$street\"
                town=\"$town\"
                county=\"$county\"
                postcode=\"$postcode\"
                phone=\"$phone\"
                WHERE id=$user_id");
}


function auth_close_account($db, $user_id) {
    // Set account closed flag
    $db->query("UPDATE user SET closed=1 WHERE id=$user_id");
}

?>