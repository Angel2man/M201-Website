<?php

function crypt_new_salt() {
    // Create a 100 byte random string
    // http://us.php.net/manual/en/function.mcrypt-create-iv.php
    $random = mcrypt_create_iv(100);
    
    // Get an MD5 hash of it (converts to hex and truncates to 32 characters)
    $salt = md5($random);
    
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
