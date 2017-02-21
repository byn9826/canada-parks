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
//check user login
document.getElementById("login").onclick = function () {
    var name = document.getElementById("login-name").value;
    var password = document.getElementById("login-password").value;
    var message = document.getElementById("login-error");
    if (!checkValidInput(name)) {
        message.innerHTML = "Name can't be empty";
        return false;
    } else if (!checkValidInput(password)) {
        message.innerHTML = "Password can't be empty";
        return false;
    } else if (!checkNameLength(name)) {
        message.innerHTML = "Username is too long";
        return false;
    } else if (!checkPassLength(password)) {
        message.innerHTML = "Password length incorrect";
        return false;
    } else {
        document.getElementById("final-password").value = CryptoJS.MD5(password);
        document.getElementById("header-login").submit();
    }
}
