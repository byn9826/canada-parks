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

});