/*Author: Sam*/

var map;
var bounds;
var service;
var infowindow;
var infos = [];
var directionsDisplay;
var directionsService = new google.maps.DirectionsService();
var current;
var destination;

function initialize() {
    
    map = new google.maps.Map(document.getElementById('map-container'), {
        zoom: 13,
        options: {
            scrollwheel: false,
        }
    });

    map.addListener('click', function() {
        closeInfoWdinows();
    });

    bounds = new google.maps.LatLngBounds();

    var image = {
        url: 'https://cdn0.iconfinder.com/data/icons/small-n-flat/24/678111-map-marker-32.png',
        // This marker is 20 pixels wide by 32 pixels high.
        size: new google.maps.Size(32, 32),
        // The origin for this image is (0, 0).
        origin: new google.maps.Point(0, 0),
        // The anchor for this image is the base of the flagpole at (0, 32).
        anchor: new google.maps.Point(0, 32)
      };
    if (typeof parks != 'undefined' || parks.length != 0) {
        parks.map(function(park) {
        var marker = new google.maps.Marker({
            position: {lat: parseFloat(park.latitude), lng: parseFloat(park.longitude)},
            map: map,
            title: park.name,
            animation: google.maps.Animation.DROP,
            icon: image
        });

        var infowindow = new google.maps.InfoWindow({
            content: park.name
        });

        marker.addListener('click', function() {
            destination = marker;
            closeInfoWdinows();
            infowindow.open(map, this);
        });

        infos.push(infowindow);

        bounds.extend(marker.position);
    });

    }

    map.fitBounds(bounds);
}

$('#get-direction').on('click', function() {
    console.log(destination);
});

$('#reset').on('click', function() {
    directionsDisplay.setMap(null);
    directionsDisplay = null;
    map.fitBounds(bounds);
});

$('#get-current-location').on('click', function() {
    directionsDisplay = new google.maps.DirectionsRenderer();
    directionsDisplay.setMap(map);
    getDirection();
});

function getDirection() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            var request = {
                origin: pos,
                destination: destination.position,
                travelMode: 'DRIVING'
            };
            directionsService.route(request, function(result, status) {
                console.log(result);
                if (status == 'OK') {
                    directionsDisplay.setDirections(result);
                }
            });
        });
    }
}

function closeInfoWdinows() {
    infos.map(function(info) {
        info.close();
    });
}
