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
if ($("#login-error").html() && $("#login-error").html().trim() !== "") {
    $("#login-dropdowm").click();
}

//google login. Modifyed from code example from google
var googleLogin = 0;
function onSignIn(googleUser) {
    //init google login only after click, solution found on http://stackoverflow.com/questions/31331428/how-to-call-getbasicprofile-of-google-to-google-signin-on-only-button-click
    if (googleLogin === 1) {
        // Useful data for your client-side scripts:
        var profile = googleUser.getBasicProfile();
        // The ID token you need to pass to your backend:
        var id_token = googleUser.getAuthResponse().id_token;
        var user_email = profile.getEmail();
        var user_name = profile.getGivenName();
        var google_profile = profile.getImageUrl();
        $.ajax({
            type: "POST",
            url: window.location.origin + '/marvel-canada' + '/lib/account/handler.php',
            data: {id: id_token, email: user_email, name: user_name, profile: google_profile},
            success: function (result) {
                if (result == 'create') {
                    window.location = document.getElementById("js-team-route").innerHTML + '/signup/';
                } else if (result == 'success') {
                    window.location = document.getElementById("js-team-route").innerHTML;
                } else if (result == 'failed') {
                    $("#login").val("Something Wrong");
                }
            }
        });
    }
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
        } else if (!document.getElementById('input-check').checked) {
            $("#signup-error").html("Please check our signup conditions");
        }
        else {
            var securePass = $("#input-password").val();
            securePass = CryptoJS.MD5(securePass);
            $("#input-password").val(securePass);
            $("#user-signup").submit();
        }
    })

    //check user login
    $("#login").click(function () {
        if (!checkValidInput($("#login-email").val())) {
            $("#login-error").html("Email can't be empty");
        } else if (!checkValidInput($("#login-password").val())) {
            $("#login-error").html("Password can't be empty");
        } else if (!validateEmail($("#login-email").val())) {
            $("#login-error").html("Email format is incorrect");
        } else if (!checkPassLength($("#login-password").val())) {
            $("#login-error").html("Password length incorrect");
        } else {
            var userPassword = $("#login-password").val();
            userPassword = CryptoJS.MD5(userPassword);
            $("#login-password").val(userPassword);
            $("#header-login").submit();
        }
    })

    //trigger google login
    $("#header-google").click(
        function () {googleLogin = 1;}
    );

    //logout userPassword
    $("#logout").submit(function() {
        gapi.load('auth2', function() {
            gapi.auth2.init({
                client_id: "168098850234-7ouvsm9ikqj9g77u623o5754kdp1t62c.apps.googleusercontent.com"
            }).then(function(auth2) {
                auth2.signOut().then(function () {
                    //console.log('User signed out.');
                });
            });
        });
    });

    //resend verify email
    $("#confirm-resend").unbind('click').bind('click', function() {
        if ($("#confirm-resend").html() == "Click to resend the link") {
            var name = $("#hide-name").val();
            var email = $("#hide-email").val();
            $.ajax({
                type: "POST",
                url: './api.php',
                data: {name: name, email: email},
                success: function (result) {
                    $("#confirm-resend").text(result);
                }
            });
        }
    });

    //force change new password
    $("#valid-repass").unbind('click').bind('click', function() {
        if (!checkValidInput($("#validpage-Password").val())) {
            $("#repass-error").html("Password can't be empty");
        } else if (!checkPassLength($("#validpage-Password").val())) {
            $("#repass-error").html("Password length should be between 8 -16");
        } else {
            var securePass = $("#validpage-Password").val();
            securePass = CryptoJS.MD5(securePass);
            $("#validpage-Password").val(securePass);
            $("#repass").submit();
        }
    });

    $( "#forget-password" ).unbind('submit').bind('submit', function(event) {
        if (!checkValidInput($("#forget-email").val())) {
            $("#forget-message").html("Email address can't be empty");
            event.preventDefault();
        } else if (!validateEmail($("#forget-email").val())) {
            $("#forget-message").html("Email format is incorrect");
            event.preventDefault();
        }
    });

    $( "#change-pass" ).unbind('submit').bind('submit', function(event) {
        if (!checkValidInput($("#change-password").val())) {
            $("#change-message").html("Password can't be empty");
            event.preventDefault();
        } else if (!checkPassLength($("#change-password").val())) {
            $("#change-message").html("Password length should be between 8 -16");
            event.preventDefault();
        } else {
            var securePass = $("#change-password").val();
            securePass = CryptoJS.MD5(securePass);
            $("#change-password").val(securePass);
        }
    });

    $("#header-hamburger").unbind('click').bind('click', function(event) {
        $("#mobile").toggle();
    });
});
