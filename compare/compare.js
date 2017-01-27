$(document).ready(function() {
    var compareParks = [];
    $('.select').on('click', function() {
        var parkId = $(this).attr('data-id');
        if ($(this).hasClass('btn-success')) {
            $(this).removeClass('btn-success');
            $(this).text('Compare');
            compareParks.splice(compareParks.indexOf(parkId), 1);
        } else {
            if (compareParks.length != 2) {
                $(this).addClass('btn-success');
                $(this).text('Selected');
                compareParks.push(parkId);   
            }
        }
        
        if (compareParks.length == 2) {
            $('#compare').removeClass('hidden');
        } else {
            $('#compare').addClass('hidden');
        }
        
    });
});