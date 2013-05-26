<?php

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

?>

