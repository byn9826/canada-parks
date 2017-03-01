/*Author: Sam*/

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
}