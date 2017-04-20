//Author: Sam
var parkIds = [];

$(document).ready(function() {
    $('#toMap').on('click', function() {
        if (typeof map == 'undefined') {
            initialize();
        }
    });
    
    $('.park').on('click', '.select', function(e) {
        e.preventDefault();
        var parkId = $(this).attr('data-id');
        if ($(this).hasClass('btn-success')) {
            unselectPark(parkId, '#compare-park' + parkId);
            
        } else {
            if (parkIds.length != 2) {
                $(this).addClass('btn-success');
                $(this).text('Selected');
                $('#compare-parks-body').append('<button data-park="' + parkId + '" id="compare-park-' + parkId +'" class="btn btn-warning selected-park" aria-label="Right Align">' + $(this).data('name') + '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>' + '</button>')
                parkIds.push(parkId);
            }
        }
        if (parkIds.length == 2) {
            $('#compare').attr('disabled', false);
            var url = '../compare?park1=' + parkIds[0] + '&park2=' + parkIds[1];
            $('#compare').attr('href', url);
        } else {
            $('#compare').attr('disabled', true);
        }
    });
    
    $('#compare-parks-body').on('click', '.selected-park', function() {
        var parkId = $(this).data('park');
        unselectPark(parkId, this);
    });
});

function unselectPark(parkId, node) {
    $('#park-' + parkId).find('.select').removeClass('btn-success').text('compare');
    parkIds.splice(parkIds.indexOf(parkId), 1);
    $(node).remove();
}