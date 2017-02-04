$(document).ready(function() {
    var parkIds = [];
    $('.select').on('click', function(e) {
        e.preventDefault();
        var parkId = $(this).attr('data-id');
        if ($(this).hasClass('btn-success')) {
            $(this).removeClass('btn-success');
            $(this).text('Compare');
            
            for (var i = 0; i < parkIds.length; i++) {
                if (parkIds[i].id = parkId) {
                    parkIds.splice(i, 1);
                }
            }
            
        } else {
            if (parkIds.length != 2) {
                $(this).addClass('btn-success');
                $(this).text('Selected');
                var park = {
                    id: parkId,
                    name: $('#park-' + parkId).find('.name').text()
                };
                parkIds.push(park);
            }
        }
        
        if (parkIds.length == 2) {
            $('#compare-1').find('.name').text(parkIds[0].name);
            $('#compare-2').find('.name').text(parkIds[1].name);
            $('#compare').attr('disabled', false);
        } else {
            $('#compare').attr('disabled', true);
        }
    });
    
    var map;
    var service;
    var infowindow;
    
    function initialize() {
        var pyrmont = new google.maps.LatLng(43.7763962,-79.3240221);
    
        map = new google.maps.Map(document.getElementById('map'), {
            center: pyrmont,
            zoom: 15
        });
    
        var request = {
            location: pyrmont,
            radius: '10000000000000',
            query: 'canada national park'
        };
    
        service = new google.maps.places.PlacesService(map);
        service.textSearch(request, callback);
    }
    
    function callback(results, status, response) {
        console.log(response);
        if (status == google.maps.places.PlacesServiceStatus.OK) {
            console.log(results);
        }
    }
    
    initialize();
});