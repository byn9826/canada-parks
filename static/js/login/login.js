//author BAO For login and signup
//input can't be empty
function checkValidInput(value) {
    if (!value || value === "") {
        return false;
    } else {
        return true;
    }
}
//username should be no more than 10 character
function checkNameLength(name) {
    if (name.length > 0 && name.length <= 10) {
        return true;
    } else {
        return false;
    }
}
//password length should be between 8 to 16
function checkPassLength(pass) {
    if (pass.length >= 8 && pass.length <= 16) {
        return true;
    } else {
        return false;
    }
}

//This code is from http://stackoverflow.com/a/46181
function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

//change login status when users submit login request
if ($("#login-error").html() && $("#login-error").html().trim() !== "username:admin-pass:12345678") {
    $("#login-dropdowm").click();
}

//google login. Modifyed from code example from google
function onSignIn(googleUser) {
    // Useful data for your client-side scripts:
    var profile = googleUser.getBasicProfile();
    console.log('Given Name: ' + profile.getGivenName());
    console.log("Image URL: " + profile.getImageUrl());
    // The ID token you need to pass to your backend:
    var id_token = googleUser.getAuthResponse().id_token;
    var user_email = profile.getEmail();
    var user_name = profile.getGivenName();
    $.ajax({
        type: "POST",
        url: 'lib/publicLogin/googleLogin.php',
        data: {id: id_token, email: user_email, name: user_name},
        success: function (result) {window.location = 'index.php';}
    });
}


//check user sign up
$(document).ready(function () {
    $("#signup-button").click(function () {
        if (!checkValidInput($("#input-name").val())) {
            $("#signup-error").html("Username can't be empty");
        } else if (!checkValidInput($("#input-password").val())) {
            $("#signup-error").html("Password can't be empty");
        } else if (!checkValidInput($("#input-email").val())) {
            $("#signup-error").html("Email can't be empty");
        } else if (!checkNameLength($("#input-name").val())) {
            $("#signup-error").html("Username is too long");
        } else if (!checkPassLength($("#input-password").val())) {
            $("#signup-error").html("Password length incorrect");
        } else if (!validateEmail($("#input-email").val())) {
            $("#signup-error").html("Email format is incorrect");
        } else {
            var securePass = $("#input-password").val();
            securePass = CryptoJS.MD5(securePass);
            $("#input-password").val(securePass);
            $("#user-signup").submit();
        }
    })
    //check user login
    $("#login").click(function () {
        if (!checkValidInput($("#login-name").val())) {
            $("#login-error").html("Name can't be empty");
        } else if (!checkValidInput($("#login-password").val())) {
            $("#login-error").html("Password can't be empty");
        } else if (!checkNameLength($("#login-name").val())) {
            $("#login-error").html("Username is too long");
        } else if (!checkPassLength($("#login-password").val())) {
            $("#login-error").html("Password length incorrect");
        } else {
            var userPassword = $("#login-password").val();
            userPassword = CryptoJS.MD5(userPassword);
            $("#login-password").val(userPassword);
            $("#header-login").submit();
        }
    })

    $("#header-google").click(



    );

});
