/**
 * Created by M. Irfaan Auhammad on 10-Feb-17.
 */
// alert('javasrcipt');
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
        $('#inputDateVisit').datepicker();
    } );


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