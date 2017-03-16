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
    
    parks.map(function(park) {
        var marker = new google.maps.Marker({
            position: {lat: parseFloat(park.latitude), lng: parseFloat(park.longitude)},
            map: map,
            title: park.name
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
    
    map.fitBounds(bounds);
}

function closeInfoWdinows() {
    infos.map(function(info) {
        info.close();
    })
}