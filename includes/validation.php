<?php

// NOTE: None of these will succeed if a quote character has been used


function validate_username($username) {
    // Check that the field has been filled in
    if ($username == null || $username == "") {
        return "Username is required";
    }
    
    // Check that username is within size limits
    $length = strlen($username);
    if ($length < 4) {
        return "This username is too short";
    }
    if ($length > 50) {
        return "This username is too long";
    }
    
    // Check that no illegal characters are being used in username
    if (!preg_match("/^[a-zA-Z0-9_\.\-]+$/", $username)) {
        return "This username is invalid";
    }
     
    // No error
    return null;
}

function validate_email_address($email_address) {
    // Check that the field has been filled in
    if ($email_address == null || $email_address == "") {
        return "Email address is required";
    }
    
    // Check that the email address is in size limits
    if (strlen($email_address) > 200) {
        return "This email address is too long";
    }
    
    // Check that this email address is valid
    // This should also check for quotes
    if (!filter_var($email_address, FILTER_VALIDATE_EMAIL)) {
        return "This email address is invalid";
    }
    
    // No error
    return null;
}

function validate_password($password1, $password2) {
    // Check that both fields have been filled in
    if ($password1 == null || $password1 == "") {
        return "Password is required";
    }
    if ($password2 == null || $password2 == "") {
        return "Please repeat password";
    }
    
    // Check that passwords match
    if ($password1 != $password2) {
        return "These passwords do not match";
    }
    
    // Check that no illegal characters are being used in password
    if (preg_match("/[\"\']/", $password1)) {
        return "This password is invalid";
    }
    
    // No error
    return null;
}

function validate_address_line($line, $required) {
    // Check that the field has been filled in
    if ($line == null || $line == "") {
        if ($required) {
            return "This field is required";
        } else {
            return null;
        }
    }
    
    // Check that this field is not too long
    if (strlen($line) > 200) {
        return "This field is too long";
    }
    
    // Check that no illegal characters are being used
    if (preg_match("/[\"\']/", $line)) {
        return "This field is invalid";
    }
    
    // No error
    return null;
}

function validate_address_postcode($postcode, $required) {
    // Check that the field has been filled in
    if ($postcode == null || $postcode == "") {
        if ($required) {
            return "Postcode is required";
        } else {
            return null;
        }
    }
    
    // Check that this field is not too long
    if (strlen($postcode) > 10) {
        return "This postcode is too long";
    }
    
    // Check that the postcode is valid
    // I got this regex from http://stackoverflow.com/questions/164979/uk-postcode-regex-comprehensive
    // I had to do some modifications to make it work though
    if (!preg_match("/^(GIR 0AA)|(((ABCDEFGHIJKLMNOPRSTWYZ][0-9][0-9]?)|(([ABCDEFGHIJKLMNOPRSTWYZ][ABCDEFGHKLMNOPQRSTUVWXY][0-9][0-9]?)|((ABCDEFGHIJKLMNOPRSTWYZ][0-9][A-HJKSTUW])|([ABCDEFGHIJKLMNOPRSTWYZ][ABCDEFGHKLMNOPQRSTUVWXY][0-9][ABEHMNPRVWXY])))) [0-9][ABDEFGHJLNPQRSTUWXYZ]{2})$/", $postcode)) {
        return "This postcode is invalid";
    }
    
    // No error
    return null;
}

function validate_address_phone_number($phone_number, $required) {
    // Check that the field has been filled in
    if ($phone_number == null || $phone_number == "") {
        if ($required) {
            return "Phone number is required";
        } else {
            return null;
        }
    }
    
    // Check that this field is not too long
    if (strlen($phone_number) > 20) {
        return "This phone number is too long";
    }
    
    // Check that the phone number is valid
    if (!preg_match("/^[0-9 -]*$/", $phone_number)) {
        return "This phone number is invalid";
    }
    
    // No error
    return null;
}

function validate_verification_key($key) {
	// Verification key must be 32 characters hexadecimal
    if (!preg_match("/^[0-9a-f]{32}$/", $key)) {
        return "Verification key is invalid";
    }
}

?>
