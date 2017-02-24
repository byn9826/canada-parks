var map;
var service;
var infowindow;

function initialize() {
  var pyrmont = new google.maps.LatLng(61.9477281,-113.6599081);

  map = new google.maps.Map(document.getElementById('map'), {
        center: pyrmont,
        zoom: 3,
        options: {
            scrollwheel: false,
        }
    });


  service = new google.maps.places.PlacesService(map);
}

function callback(results, status) {
    var bounds = new google.maps.LatLngBounds();
    if (status == google.maps.places.PlacesServiceStatus.OK) {
        for (var i = 0; i < results.length; i++) {
            var marker = createMarker(results[i]);
            bounds.extend(marker.position);
        }
        map.fitBounds(bounds);
    }
}

function createMarker(place) {
    var marker = new google.maps.Marker({
        map: map,
        position: place.geometry.location,
        data: place,
    });
    
    var infowindow = new google.maps.InfoWindow();
    
    google.maps.event.addListener(marker, 'click', function() {
        infowindow.setContent(place.name);
        infowindow.open(map, this);
        
        service.getDetails({
            placeId: this.data.place_id
        }, function(place, status) {
            if (status === google.maps.places.PlacesServiceStatus.OK) {
                renderForm(place);
            }
        });
        
    });
    return marker;
}

function renderForm(place) {
    $('#name').val(place.name);
    $('#address').val(place.formatted_address);
    $('#phone_number').val(place.formatted_phone_number);
    $('#latitude').val(place.geometry.location.lat());
    $('#longitude').val(place.geometry.location.lng());
    $('#website').val(place.website);
    $('#google_place_id').val(place.place_id);
    
    place.address_components.map(function(address) {
        if (address.types[0] == 'administrative_area_level_1') {
            $('#province').val(address.long_name);
            $('#province_code').val(address.short_name);
        }
        
        if (address.types[0] == 'country') {
            $('#country').val(address.long_name);
            $('#country_code').val(address.short_name);
        }
        
        if (address.types[0] == 'postal_code' || address.types[0] == 'postal_code_prefix') {
            $('#postal_code').val(address.long_name);
        }
    });
    
    renderPhoto(place.photos);
}

function renderPhoto(photos) {
    var photosHTML = '';
    photos.map(function(photo) {
        var photoUrl = photo.getUrl({'maxWidth': 400, 'maxHeight': 300});
        var photoHTML = '<img class="col-md-3 park-banner" src="' + photoUrl + '" />';
        photosHTML += photoHTML;
    });
    $('#photos').html(photosHTML);
}

$(document).ready(function() {
    $('#map').height($('#form').height());
    initialize();
    
    $('#photos').on('click', '.park-banner', function() {
        var src = $(this).attr('src');
        $('#banner').val(src);
    });
    
    $('#search').on('click', function() {
        var request = {
            //location: pyrmont,
            //radius: '500',
            query: $('#place').val()
        };
        service.textSearch(request, callback);
    });
    
});