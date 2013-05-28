<?php

function crypt_new_salt() {
    // Create a 32 digit hex number
    $salt = md5(uniqid("SALT", true));
    
    // Return
    return $salt;
}

function crypt_get_hash($plaintext, $salt) {
    // Initialise hash
    $hash = $plaintext;
    
    // Do 5000 rounds of MD5
    for ($i = 0; $i < 5000; $i++) {
        $hash = md5($salt.$hash);
    }
    
    // Return hash
    return $hash;
}

?>
