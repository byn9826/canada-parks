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
        } else {
            footprintMessage = "Sorry. Currently, we are not able to add your new footprint."
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

    // -- Initialise date pickers
    $(function() {
        $('#inputDateVisit').datepicker();
    } );

    // -- Handle form when User Adds a new footprint
    $('#frmAddFootprint').submit(function(e) {

        // Capture form data
        //var frmFootprint = document.forms.frmAddFootprint;
        //var iParkId = $('#slctPark').val();
        var dDateVisited = $('#inputDateVisit').val();
        // var sUserStory = $('#inputStory').val();
        // if ( $('#isPublic').is(':checked') )
        //     var fSharePublic = $('#isPublic').val();
        // else
        //     var fSharePublic = 'N';

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

    // -- Handle delete a footprint post
    $('button.delete-footprint').on('click', function(e) {
        e.preventDefault();
        var footElementId = $(this).attr('data-footElementId');
        var footprintId = $(this).attr('data-footprintId');

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
    });

    // -- Handle delete a wishlist item
    $('a.del-wishitem').on('click', function(e) {
        e.preventDefault();
        var wishElementId = $(this).attr('data-wishElmt');
        var wishId = $(this).attr('data-wishId');

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
    });

});