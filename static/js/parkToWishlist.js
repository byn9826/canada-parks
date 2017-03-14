/**
 * Created by M. Irfaan Auhammad on 12-Mar-17.
 */

$(document).ready(function() {

    // Handle action when user clicks 'Add to wishlist'
    $('button.parkToWishlist').on('click', function() {
        //alert('add to wishlist' + $(this).attr('data-parkId'));
        var parentDIV = $(this).parent();
        var parkId = $(this).attr('data-parkId');

        // Add park to wishlist asynchronously
        var dataString = 'addToWishlist=' + true + '&park_id=' + parkId;
        $.ajax({
            type: "post",
            url: '../lib/profile/manageWishlist.php',
            data: dataString,
            success: function(result) {
                // on success change display on page
                if(result === "Added") {
                    var btn = $('<button type="button" class="btn btn-link eye" title="Park listed in wish list"><span class="glyphicon glyphicon-eye-open ai-glyphicon"></button>');
                    parentDIV.html('');
                    parentDIV.append(btn);
                } else {
                    alert("Unable to add park to wishlist.");
                }
            }
        });

    }); // end of button click

    // Handle click on eye to go to wishlist
    // Event handled this way to work on dynamically added buttons from jQuery
    $(document).on('click', 'button.eye', function(e) {
        window.location.href = "../profile/index.php?wishlist=true";
    });

});