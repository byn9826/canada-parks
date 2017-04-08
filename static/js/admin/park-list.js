$(document).ready(function() {
    
    $('.delete-park').on('click', function() {
        var id = $(this).data('park');
        $('#confirm-delete').data('park', id);
    });
    
    $('#confirm-delete').on('click', function() {
        var id = $(this).data('park');
        $.ajax({
            url: '../../../lib/park/ParkController.php?action=delete',
            data: {id: id},
            method: 'POST',
            success: function(res) {
                if (JSON.parse(res).code == 200) {
                    $('#park-' + id).remove();
                }
            }
        });
        $('.delete').modal('hide')
    });
});