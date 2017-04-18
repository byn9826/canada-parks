/**
 * Created by M. Irfaan Auhammad on 04-Apr-17.
 */
$(document).ready(function() {
    //console.log(iParkId);
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

    // -- Function to load footprints using AJAX
    function pLoadFootprintSeries() {
        // Send park Id, number of rows to fetch max and from which row to retrieve
        var dataString = 'btnLoadParkFootprints=' + true + '&park_id=' + iParkId + '&from_row_num=' + iFootprintsToLoad + '&rows_per_load=' + iNumRowsPerLoad;

        // AJAX call to load footprints from DB
        $.ajax({
            type: "post",
            url: '../lib/profile/manageFootprints.php',
            data: dataString,
            success: function(result) {
                //console.log(result);
                // Find out how many footprints were retrieved
                var iNumOfFootprintsFound = $(result).filter('div.display-group').length;

                // on success display footprints loaded
                var footId = 'footprints_' + iFootprintsToLoad;
                var $div = $("<div>", {id: footId, "class": "collapse"});
                $('#' + footId).collapse("hide");

                if(result !== "") {
                    $div.html(result);
                    iFootprintsToLoad += iNumRowsPerLoad;
                    if(iNumOfFootprintsFound == iNumRowsPerLoad) {
                        setTimeout(function() {
                            $('button.btn-load-footprints').html('Load More');
                            $('button.btn-load-footprints').show();
                        }, 700);
                    } else {
                        setTimeout(function() {
                            $('button.btn-load-footprints').hide('slow');
                        }, 1000);

                    }

                } else {
                    if(iFootprintsToLoad > 0) {
                        $div.html('No more footprints available ...');
                    } else {
                        $div.html('No footprints available at this time ...');
                    }

                    $('button.btn-load-footprints').hide('slow');
                }

                $('div.park-footprints__container').append($div);
                pInitialiseCarousel();
                setTimeout(function() {
                    $('#' + footId).slideDown(1000);
                }, 500);
            }
        });

    }   // end of function pLoadFootprintSeries()

    // Global counter to keep track of footprints load
    $('button.btn-load-footprints').hide();
    var iNumRowsPerLoad = 5;
    var iFootprintsToLoad = 0;

    // Load first 5 footprints on page load
    pLoadFootprintSeries();

    // Handle event when user clicks button to load footprints
    $('button.btn-load-footprints').click(function() {
        // Load footprints using AJAX
        pLoadFootprintSeries();
    });

});