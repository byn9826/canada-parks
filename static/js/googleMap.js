var GoogleMap = function(dom) {
    var map;
    var markers = [];
    var infos = [];
    var bounds = new google.maps.LatLngBounds();
    var icon = {
        url: 'https://cdn0.iconfinder.com/data/icons/small-n-flat/24/678111-map-marker-32.png',
        // This marker is 20 pixels wide by 32 pixels high.
        size: new google.maps.Size(32, 32),
        // The origin for this image is (0, 0).
        origin: new google.maps.Point(0, 0),
        // The anchor for this image is the base of the flagpole at (0, 32).
        anchor: new google.maps.Point(0, 32)
    };
    this.initialize = function() {
        map = new google.maps.Map(document.getElementById(dom), {
            zoom: 13,
            options: {
                scrollwheel: false,
            }
        });
    };
    this.renderMarkers = function(markers) {
        markers.map(function(marker) {
            var marker = new google.maps.Marker({
                position: {lat: parseFloat(marker.latitude), lng: parseFloat(marker.longitude)},
                map: map,
                title: marker.name,
                animation: google.maps.Animation.DROP,
                icon: icon
            });
            
            var infowindow = new google.maps.InfoWindow({
                content: marker.name
            });
            
            marker.addListener('click', function() {
                this.closeInfoWdinows();
                infowindow.open(map, this);
            });
            
            infos.push(infowindow);
            
            bounds.extend(marker.position);
        });
        
        map.fitBounds(bounds);
    };
    
    this.closeInfoWdinows = function() {
        this.infos.map(function(info) {
            info.close();
        });
    }
};