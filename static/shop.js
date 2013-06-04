// Show more results

var page = 1;

function show_more_results() {
    // Work out url
    var url = "index.php?p=" + page + "&layout=none";
    
    // Check for category
    var cat = $.url().param("cat");
    if (cat) {
        url += "&cat=" + cat;
    }
    
    // Request data
    $.ajax({
        url: url,
        success: function (data) {
            // A really hackish way to check if any data was returned
            if (data.length > 10) {
                $("#product_list").append(data);
            } else {
                $("#show_more_results").html("No more results to show");
            }
        }
    });
    
    // Increase page
    page++;
}



// Validation

function validate_username(username) {
    // Check that the field has been filled in
    if (username == null || username == "") {
        return null;
    }
    
    // Check that username is within size limits
    if (username.length < 4) {
        return null;
    }
    if (username.length > 50) {
        return false;
    }
    
    // Check that no illegal characters are being used in username
    if (!/^[a-zA-Z0-9_\.\-]+$/.test(username)) {
        return false;
    }
     
    // No error
    return true;
}

function validate_email_address(email_address) {
    // Check that the field has been filled in
    if (email_address == null || email_address == "") {
        return null;
    }
    
    // Check that the email address is in size limits
    if (email_address.length > 200) {
        return false;
    }
    
    // Check that this email address is valid
    // This should also check for quotes
    // This regex is from http://stackoverflow.com/questions/201323/using-a-regular-expression-to-validate-an-email-address
    if (!/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/i.test(email_address)) {
        return false;
    }
    
    // No error
    return true;
}

function validate_password1(password1) {
    // Check that this field has been filled in
    if (password1 == null || password1 == "") {
        return null;
    }
    
    // Check that no illegal characters are being used in password
    if (/[\"\']/.test(password1)) {
        return false;
    }
    
    // No error
    return true;
}

function validate_password2(password1, password2) {
    // Check that this field has been filled in
    if (password2 == null || password2 == "") {
        return null;
    }
    
    // Check that passwords match
    if (password1 != password2) {
        return false;
    }
    
    // No error
    return true;
}

function validate_address_line(line) {
    // Check that the field has been filled in
    if (line == null || line == "") {
        return null;
    }
    
    // Check that this field is not too long
    if (line.length > 200) {
        return false;
    }
    
    // Check that no illegal characters are being used
    if (/[\"\']/.test(line)) {
        return false;
    }
    
    // No error
    return true;
}

function validate_address_postcode(postcode) {
    // Check that the field has been filled in
    if (postcode == null || postcode == "") {
        return null;
    }
    
    // Check that this field is not too long
    if (postcode.length > 10) {
        return false;
    }
    
    // Check that the postcode is valid
    // I got this regex from http://stackoverflow.com/questions/164979/uk-postcode-regex-comprehensive
    // I had to do some modifications to make it work though
    if (!/^(GIR 0AA)|(((ABCDEFGHIJKLMNOPRSTWYZ][0-9][0-9]?)|(([ABCDEFGHIJKLMNOPRSTWYZ][ABCDEFGHKLMNOPQRSTUVWXY][0-9][0-9]?)|((ABCDEFGHIJKLMNOPRSTWYZ][0-9][A-HJKSTUW])|([ABCDEFGHIJKLMNOPRSTWYZ][ABCDEFGHKLMNOPQRSTUVWXY][0-9][ABEHMNPRVWXY])))) [0-9][ABDEFGHJLNPQRSTUWXYZ]{2})$/i.test(postcode)) {
        return false;
    }
    
    // No error
    return true;
}

function validate_address_phone_number(phone_number) {
    // Check that the field has been filled in
    if (phone_number == null || phone_number == "") {
        return null;
    }
    
    // Check that this field is not too long
    if (phone_number.length > 20) {
        return false;
    }
    
    // Check that the phone number is valid
    if (!/^[0-9 -]*$/.test(phone_number)) {
        return false;
    }
    
    // No error
    return true;
}

function validate_verificationkey(key) {
	// Verification key must be 32 characters hexadecimal
    if (!/^[0-9a-f]{32}$/.test(key)) {
        return false;
    }
    
    // No error
    return true;
}


function set_field_valid_indicator(field, valid) {
    // Set a class depending on weather the field is valid or not
    switch (valid) {
        case true:
            field.className = "field_valid";
        break;
        case false:
            field.className = "field_invalid";
        break;
        default:
            field.className = "";
        break;
    }
}


// This must be executed after all HTML has been parsed
// This function simply looks through the whole document for fields that can be validated
$(document).ready(function() {
    // Username field
    $("input[name='username']").on("input", function(event) {
        var field = event.target;
        set_field_valid_indicator(field, validate_username(field.value));
    });
    
    // Password fields
    $("input[name='password']").on("input", function(event) {
        var field = event.target;
        set_field_valid_indicator(field, validate_password1(field.value));
    });
    $("input[name='password1']").on("input", function(event) {
        var field = event.target;
        set_field_valid_indicator(field, validate_password1(field.value));
    });
    $("input[name='password2']").on("input", function(event) {
        var field = event.target;
        set_field_valid_indicator(field, validate_password2($("input[name='password1']")[0].value, field.value));
    });
    
    // Email field
    $("input[name='email']").on("input", function(event) {
        var field = event.target;
        set_field_valid_indicator(field, validate_email_address(field.value));
    });
    
    // Address fields
    $("input[name='name']").on("input", function(event) {
        var field = event.target;
        set_field_valid_indicator(field, validate_address_line(field.value));
    });
    $("input[name='address1']").on("input", function(event) {
        var field = event.target;
        set_field_valid_indicator(field, validate_address_line(field.value));
    });
    $("input[name='address2']").on("input", function(event) {
        var field = event.target;
        set_field_valid_indicator(field, validate_address_line(field.value));
    });
    $("input[name='town']").on("input", function(event) {
        var field = event.target;
        set_field_valid_indicator(field, validate_address_line(field.value));
    });
    $("input[name='county']").on("input", function(event) {
        var field = event.target;
        set_field_valid_indicator(field, validate_address_line(field.value));
    });
    $("input[name='postcode']").on("input", function(event) {
        var field = event.target;
        set_field_valid_indicator(field, validate_address_postcode(field.value));
    });
    $("input[name='phone']").on("input", function(event) {
        var field = event.target;
        set_field_valid_indicator(field, validate_address_phone_number(field.value));
    });
    
    // Verification key field
    $("input[name='key']").on("input", function(event) {
        var field = event.target;
        set_field_valid_indicator(field, validate_verificationkey(field.value));
    });
});
