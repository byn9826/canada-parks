/**
 * Created by M. Irfaan Auhammad on 10-Feb-17.
 */

$(document).ready(function() {

    // -- Scroll window automatically to match hash
    if(window.location.hash) {
        // smooth scroll to the anchor id
        $('html, body').animate({
            scrollTop: $(window.location.hash).offset().top + 'px'
        }, 1000, 'swing');
    }


    // -- Initialise date pickers
    $(function() {
        $('#inputDOB').datepicker();
    } );
    $(function() {
        $('#inputDateVisit').datepicker();
    } );


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