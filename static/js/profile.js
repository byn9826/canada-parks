/**
 * Created by M. Irfaan Auhammad on 10-Feb-17.
 */

$(document).ready(function() {

    // -- Handle Query string to check if user just created a footprint
    if(footprintStatus !== "") {
        var footprintMessage;
        var messageType;
        if(footprintStatus === "s") {
            footprintMessage = "Your new footprint was added successfully.";
            messageType = "success";
        } else if(footprintStatus === "e") {
            footprintMessage = "Your footprint has been updated successfully.";
            messageType = "success";
        } else {
            footprintMessage = "Sorry. Currently, we are not able to perform any footprint operation."
            messageType = "warning";
        }
        $.alert(footprintMessage,{
            autoClose: true,
            closeTime: 5000,
            type: messageType,
            isOnly: true,
            position: ['top-right', [0, 25]],
            minTop: 50,
        });
    }

    // -- Scroll window automatically to match hash
    if(window.location.hash) {
        // smooth scroll to the anchor id
        $('html, body').animate({
            scrollTop: $(window.location.hash).offset().top + 'px'
        }, 1000, 'swing');
    }

    // -- Initialise the Carousel for images
    function pInitialiseCarousel() {
        var owl = $('.owl-carousel');
        owl.owlCarousel({
            margin: 5,
            nav: true,
            // loop: true,
            responsive: {
                0: {
                    items: 1
                },
                420: {
                    items: 2
                },
                700: {
                    items: 3
                }
            }
        })
    }
    pInitialiseCarousel();

    // -- Initialise date pickers
    $(function() {
        $('#inputDateVisit').datepicker();
        $('#editDateVisit').datepicker();
    } );

    // -- Handle form when User Adds a new footprint
    $('#frmAddFootprint').submit(function(e) {

        // Capture form data
        var dDateVisited = $('#inputDateVisit').val();

        // Perform validation
        if(dDateVisited === "") {
            $('#errFootprintDate').html('Please select a date')
            return false;
        } else {
            $('#errFootprintDate').html('');
        }

    });

    // -- Reset form is user hits Cancel button
    $('#btnCancelFootprint').on('click', function () {
        $('#frmAddFootprint').trigger('reset');
    });

    // -- Handle 'Edit' event and display footprint details to edit
    $('span.edit-footprint').on('click', function(e) {
        // Get footprint Id to edit
        var footprintId = $(this).attr('data-footprintId');

        // Get footprint details using AJAX
        var dataString = 'footprintToEdit=' + true + '&footprint_id=' + footprintId;
        $.ajax({
            type: "get",
            url: '../lib/profile/manageFootprints.php',
            data: dataString,
            success: function(result) {
                // Capture footprint details
                var parkId = result[0].park_id;
                var dateVisited = result[0].date_visited;
                var formattedDate = dateVisited.substring(5,7) + '/' + dateVisited.substring(8,10) + '/' + dateVisited.substring(0,4);
                var userStory = result[0].user_story;
                if(result[0].is_public === "Y") {
                    var postIsPublic = true;
                } else {
                    var postIsPublic = false;
                }
                var createdOn = result[0].created_on;

                // Construct image display
                var sFolderPath = '../static/img/profile/footprints/' + currentUserId + '_' + footprintId + '/';
                var displayImages = "";
                if(result[1].length > 0) {
                    displayImages += '<div class="owl-carousel owl-theme footprint__gallery_edit">';
                    $.each(result[1], function(index, objImage) {
                        var sImagePath = sFolderPath + objImage.image_src;
                        displayImages += '<div class="item edit-image">';
                        displayImages += '<button type="button" class="close del-foot-img" data-footprintId="' + footprintId + '" data-imageSrc="' + objImage.image_src + '" data-imageId="'+ objImage.image_id + '" title=\"Delete this image\" aria-label=\"Delete image from footprint\">';
                        displayImages += '<span aria-hidden="true">&times;</span>';
                        displayImages += '</button>';
                        displayImages += '<img src="' + sImagePath + '" />';
                        displayImages += '</div>';
                    });
                    displayImages += '</div>';
                }

                // Set value to HTML controls
                $('#editFootprintId').val(footprintId);
                $('#editCreatedOn').val(createdOn);
                $('#editSlctPark').val(parkId);
                $('#editDateVisit').val(formattedDate);
                $('#editStory').val(userStory);
                $('#eIsPublic').prop('checked', postIsPublic);
                $('#editFootprintGallery').html(displayImages);
                pInitialiseCarousel();
            }
        });

        // Display footprint details in modal form
        var t = setTimeout(function() {
            $('#editFootprint').modal('show');
        }, 300);
    });

    // -- Handle form when User Edit a footprint
    $('#frmEditFootprint').submit(function(e) {

        // Capture form data
        var dDateVisited = $('#editDateVisit').val();

        // Perform validation
        if(dDateVisited === "") {
            $('#errEditFootprintDate').html('Please select a date')
            return false;
        } else {
            $('#errEditFootprintDate').html('');
        }

    });

    // -- Handle delete a footprint post
    $('button.delete-footprint').on('click', function(e) {
        e.preventDefault();
        var footElementId = $(this).attr('data-footElementId');
        var footprintId = $(this).attr('data-footprintId');

        // Get user's confirmation for delete action
        bootbox.confirm({
            title: "Destroy footprint?",
            message: "Are you sure you want to permanently delete this post? This cannot be undone.",
            buttons: {
                cancel: {
                    label: '<i class="fa fa-times"></i> Cancel'
                },
                confirm: {
                    label: '<i class="fa fa-check"></i> Delete'
                }
            },
            callback: function (result) {
                if(result === true) {
                    // AJAX delete footprint item
                    var dataString = 'deleteFootprint=' + true + '&footprint_id=' + footprintId;
                    $.ajax({
                        type: "post",
                        url: '../lib/profile/manageFootprints.php',
                        data: dataString,
                        success: function(result) {
                            // On success change display on page
                            if(result === "Deleted") {
                                var footprintElement = document.getElementById(footElementId);
                                $(footprintElement).hide(1000);
                                setTimeout(function() {
                                    $(footprintElement).remove();
                                }, 2000);
                            } else {
                                alert("Unable to remove selected footprint right now.");
                            }
                        }
                    });
                }
            }
        });
    });

    // -- Handle delete a footprint image
    $(document.body).on('click', '.del-foot-img', function() {

        // Capture image details to delete an image
        var imageItem = $(this).closest('div.owl-item');
        var footprintId = $(this).attr('data-footprintid');
        var imageId = $(this).attr('data-imageid');
        var imageSrc = $(this).attr('data-imagesrc');

        // Confirm user's delete action
        bootbox.confirm({
            title: "Delete image?",
            message: "Are you sure you want to permanently delete this image from your footprint?",
            buttons: {
                cancel: {
                    label: '<i class="fa fa-times"></i> Cancel'
                },
                confirm: {
                    label: '<i class="fa fa-check"></i> Delete'
                }
            },
            callback: function (result) {
                if(result === true) {
                    // AJAX delete footprint image
                    var dataString = 'deleteFootImg=' + true + '&footprint_id=' + footprintId + '&image_id=' + imageId + '&image_src=' + imageSrc;
                    $.ajax({
                        type: "post",
                        url: '../lib/profile/manageFootprints.php',
                        data: dataString,
                        success: function(result) {
                            // On success, remove element from footprint
                            if(result == "Deleted") {
                                imageItem.hide(1000);
                                setTimeout(function() {
                                    $(imageItem).remove();
                                }, 2000);
                            } else {
                                alert("Unable to delete selected image right now.");
                            }
                        }
                    });
                }
            }
        });

    });

    // -- Handle delete a wishlist item
    $('a.del-wishitem').on('click', function(e) {

        e.preventDefault(); // Prevent default action

        // Capture wish item details
        var wishElementId = $(this).attr('data-wishElmt');
        var wishId = $(this).attr('data-wishId');

        // -- Get confirmation from user for their action
        bootbox.confirm({
            title: "Remove wishist item?",
            message: "Do you want to remove this park from your wishlist?",
            buttons: {
                cancel: {
                    label: '<i class="fa fa-times"></i> Cancel'
                },
                confirm: {
                    label: '<i class="fa fa-check"></i> Remove'
                }
            },
            callback: function (result) {
                if(result === true) {
                    // AJAX delete wish item
                    var dataString = 'delFromWishlist=' + true + '&wish_id=' + wishId;
                    $.ajax({
                        type: "post",
                        url: '../lib/profile/manageWishlist.php',
                        data: dataString,
                        success: function(result) {
                            // on success change display on page
                            if(result === "Deleted") {
                                var wishItemElement = document.getElementById(wishElementId);
                                $(wishItemElement).hide(1000);  // Hide wishlist item first with animation
                                setTimeout(function() {
                                    $(wishItemElement).remove();    // Remove item from DOM
                                }, 2000);
                            } else {
                                alert("Unable to remove park from wishlist.");
                            }
                        }
                    });
                }
            }
        });

    });

});