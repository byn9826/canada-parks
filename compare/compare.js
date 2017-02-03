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
});