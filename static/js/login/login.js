//author BAO
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

//change login status when users submit login request
if (!$("#login-error").html() || $("#login-error").html().trim() !== "username:admin-pass:12345678") {
    $("#login-dropdowm").click();
}

//check user login by ajax
$(document).ready(function () {
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
});
