/**
 * Created by M. Irfaan Auhammad on 13-Mar-17.
 */

$(document).ready(function() {

    // -- Initialise date pickers
    $(function() {
        $('#inputDOB').datepicker();
    } );


    // ===== FORM HANDLING ===== //
    // ========================= //
    function checkValidInput(value) {
        if (!value || value === "") {
            return false;
        } else {
            return true;
        }
    }

    //This code is from http://stackoverflow.com/a/46181
    function validateEmail(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }

    //password length should be between 8 to 16
    function checkPassLength(pass) {
        if (pass.length >= 8 && pass.length <= 16) {
            return true;
        } else {
            return false;
        }
    }


    var frmUpdatePassword = document.forms.frmUpdatePassword;
    var frmUpdateEmail = document.forms.frmUpdateEmail;
    frmUpdatePassword.onsubmit = changePassword;
    frmUpdateEmail.onsubmit = changeEmail;

    function changePassword() {
        var fFormValid = true;

        // Empty error messages
        $("#errOldPass").html("");
        $("#errNewPass").html("");
        $("#errConfirmNewPass").html("");

        // Perform form validations
        if(!checkValidInput($("#inputOldPass").val())) {
            $("#errOldPass").html("Please enter the current password");
            fFormValid = false;
        }else if (!checkValidInput($("#inputNewPass1").val())) {
            $("#errNewPass").html("Please enter a new password");
            fFormValid = false;
        } else if ($("#inputOldPass").val() === $("#inputNewPass1").val()) {
            $("#errNewPass").html("New password must be different from the old password");
            fFormValid = false;
        } else if(!checkPassLength($("#inputNewPass1").val())) {
            $("#errNewPass").html("Password should be between 8 to 16 characters");
            fFormValid = false;
        } else if (!checkValidInput($("#inputNewPass2").val())) {
            $("#errConfirmNewPass").html("Please re-enter the new password again");
            fFormValid = false;
        } else if ($("#inputNewPass1").val() !== $("#inputNewPass2").val()) {
            $("#errConfirmNewPass").html("Confirm password does not match new password");
            fFormValid = false;
        }

        if(fFormValid === true) {
            var secureOld = $("#inputOldPass").val();
            var securePass = $("#inputNewPass1").val();
            secureOld = CryptoJS.MD5(secureOld);
            securePass = CryptoJS.MD5(securePass);
            $("#inputOldPass").val(secureOld);
            $("#inputNewPass1").val(securePass);
            $("#inputNewPass2").val(securePass);
        } else {
            return false;
        }
    }

    function changeEmail() {
        var fFormValid = true;

        // Empty error messages
        $("#errEmail").html("");
        $("#errPassword").html("");

        // Perform form validations
        if(!checkValidInput($("#inputEmail").val())) {
            $("#errEmail").html("Please enter an email address");
            fFormValid = false;
        } else if(!validateEmail($("#inputEmail").val())) {
            $("#errEmail").html("Please enter a valid email address format");
            fFormValid = false;
        } else if(!checkValidInput($("#inputPassword").val())) {
            $("#errPassword").html("Please enter your password");
            fFormValid = false;
        }

        if(fFormValid === true) {
            var accPassword = $("#inputPassword").val();
            accPassword = CryptoJS.MD5(accPassword);
            $("#inputPassword").val(accPassword);
        } else {
            return false;
        }
    }


    // ===== FUNCTIONS & EVENTS TO HANDLE CHANGE PROFILE PICTURE ===== //
    // =============================================================== //
    // -- Show modal window when user clicks on change profile picture link
    $('#change-profile-pic').on('click', function() {
        $('#profile_pic_modal').modal({show:true});
    });

    // -- Show image preview when user selects an image
    $('#profile-pic').on('change', function() {
        $('#preview-profile-pic').html('');
        $('#preview-profile-pic').html('Uploading ...');
        $('#cropimage').ajaxForm(
            {
                target: '#preview-profile-pic',
                success: function() {
                    $('img#photo').imgAreaSelect({
                        aspectRatio: '1:1',
                        onSelectEnd: getSizes
                    });
                    $('#image_name').val($('#photo').attr('file-name'));
                }
            }
        ).submit();
    });

    // -- Handle logic when user click 'Crop & Save' button
    $('#save_crop').on('click', function(e){
        e.preventDefault();
        params = {
            targetUrl: 'change_pic.php?action=save',
            action: 'save',
            x_axis: jQuery('#hdn-x1-axis').val(),
            y_axis : jQuery('#hdn-y1-axis').val(),
            x2_axis: jQuery('#hdn-x2-axis').val(),
            y2_axis : jQuery('#hdn-y2-axis').val(),
            thumb_width : jQuery('#hdn-thumb-width').val(),
            thumb_height:jQuery('#hdn-thumb-height').val()
        };
        saveCropImage(params);
    });

    // -- Function called when user Cancel changes
    $('#cancel_change').on('click', function(e) {
        e.preventDefault();
        $.ajax({
            url: 'change_pic.php',
            dataType: 'html',
            data: {
                action: 'cancel',
                id: $('#hdn-profile-id').val(),
                t: 'ajax',
                image_name: $('#image_name').val()
            },
            type: 'post',
            success: function() {
                jQuery('#profile_pic_modal').modal('hide');
                jQuery(".imgareaselect-border1,.imgareaselect-border2,.imgareaselect-border3,.imgareaselect-border4,.imgareaselect-border2,.imgareaselect-outer").css('display', 'none');
                jQuery("#preview-profile-pic").html('');
                jQuery("#profile-pic").val('');
            }
        });
    });

    // -- Function to get images size
    function getSizes(img, obj){
        var x_axis = obj.x1;
        var x2_axis = obj.x2;
        var y_axis = obj.y1;
        var y2_axis = obj.y2;
        var thumb_width = obj.width;
        var thumb_height = obj.height;
        if(thumb_width > 0) {
            $('#hdn-x1-axis').val(x_axis);
            $('#hdn-y1-axis').val(y_axis);
            $('#hdn-x2-axis').val(x2_axis);
            $('#hdn-y2-axis').val(y2_axis);
            $('#hdn-thumb-width').val(thumb_width);
            $('#hdn-thumb-height').val(thumb_height);
        } else {
            alert("Please select crop area!");
        }
    }

    // -- Function to save crop images
    function saveCropImage(params) {
        $.ajax({
            url: params['targetUrl'],
            cache: false,
            dataType: "html",
            data: {
                action: params['action'],
                id: jQuery('#hdn-profile-id').val(),
                t: 'ajax',
                w1:params['thumb_width'],
                x1:params['x_axis'],
                h1:params['thumb_height'],
                y1:params['y_axis'],
                x2:params['x2_axis'],
                y2:params['y2_axis'],
                image_name: $('#image_name').val()
            },
            type: 'Post',
            success: function (response) {
                $('#profile_pic_modal').modal('hide');
                $(".imgareaselect-border1,.imgareaselect-border2,.imgareaselect-border3,.imgareaselect-border4,.imgareaselect-border2,.imgareaselect-outer").css('display', 'none');
                $("#profile_picture").attr('src', response);
                $("#preview-profile-pic").html('');
                $("#profile-pic").val();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert('status Code:' + xhr.status + 'Error Message :' + thrownError);
            }
        });
    }


});
