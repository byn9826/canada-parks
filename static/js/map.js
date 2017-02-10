var map;
var service;
var infowindow;

function initialize() {

    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 13,
        options: {
            scrollwheel: false,
        }
    });
    
    var bounds = new google.maps.LatLngBounds();
    
    parks.map(function(park) {
        var marker = new google.maps.Marker({
            position: {lat: parseFloat(park.latitude), lng: parseFloat(park.longitude)},
            map: map,
            title: park.name
        });
        
        bounds.extend(marker.position);
    });
    
    map.fitBounds(bounds);

    // var request = {
    //     location: pyrmont,
    //     radius: '10000000000000',
    //     query: 'canada national park'
    // };

    // service = new google.maps.places.PlacesService(map);
    // service.textSearch(request, callback);
}

// function callback(results, status, response) {
//     console.log(response);
//     if (status == google.maps.places.PlacesServiceStatus.OK) {
//         console.log(results);
//     }
// }

initialize();