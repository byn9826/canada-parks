/*Author: Sam*/

var map;
var service;
var infowindow;
var infos = [];

function initialize() {

    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 13,
        options: {
            scrollwheel: false,
        }
    });

    map.addListener('click', function() {
        closeInfoWdinows();
    });

    var bounds = new google.maps.LatLngBounds();

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
            closeInfoWdinows();
            infowindow.open(map, this);
        });

        infos.push(infowindow);

        bounds.extend(marker.position);
    });
<<<<<<< HEAD

=======
    }

>>>>>>> 131c518bdd7a0d0104bc691ba2f1e4248e6d63c6
    map.fitBounds(bounds);
}

function closeInfoWdinows() {
    infos.map(function(info) {
        info.close();
    });
}
