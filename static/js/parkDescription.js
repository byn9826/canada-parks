/**
 * Created by M. Irfaan Auhammad on 04-Apr-17.
 */
$(document).ready(function() {

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

    // Global counter to keep track of footprints load
    var iNumRowsPerLoad = 5;
    var iFootprintsToLoad = 0;

    // Handle event when user clicks button to load footprints
    $('button.btn-load-footprints').click(function() {
        // Capture park id
        var iParkId = $(this).attr('data-park-id');

        // AJAX delete wish item
        var dataString = 'btnLoadParkFootprints=' + true + '&park_id=' + iParkId + '&from_row_num=' + iFootprintsToLoad + '&rows_per_load=' + iNumRowsPerLoad;
        console.log(dataString);
        $.ajax({
            type: "post",
            url: '../lib/profile/manageFootprints.php',
            data: dataString,
            success: function(result) {
                //console.log(result);
                // on success display footprints loaded
                var footId = 'footprints_' + iFootprintsToLoad;
                var $div = $("<div>", {id: footId, "class": "collapse"});
                $('#' + footId).collapse("hide");

                if(result !== "") {
                    $div.html(result);
                    iFootprintsToLoad += iNumRowsPerLoad;
                    setTimeout(function() {
                        $('button.btn-load-footprints').html('Load More');
                    }, 700);

                } else {
                    if(iFootprintsToLoad > 0) {
                        $div.html('No more footprints available ...');
                        setTimeout(function() {
                            $('button.btn-load-footprints').hide('slow');
                        }, 700);
                    } else {
                        $div.html('No footprints available at this time ...');
                    }
                }

                $('div.park-footprints__container').append($div);
                pInitialiseCarousel();
                setTimeout(function() {
                    $('#' + footId).slideDown(2000);
                }, 500);
            }
        });
    });

});