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
                alert(result);
                if(result === "Added") {
                    parentDIV.html("Is in wishlist.");
                } else {
                    alert("Unable to add park to wishlist.");
                }
            }
        });

    }); // end of button click


});