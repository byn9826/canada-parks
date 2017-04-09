$(document).ready(function() {
    
    $('#search-park').on('keyup', function() {
        var name = $(this).val();
        if (name == '') {
            $('#search-park-result').html('');
            return;
        }
        $.ajax({
            url: '../../../lib/park/ParkController.php?action=getlist',
            method: 'GET',
            data: {name: name},
            success: function(res) {
                var parks = JSON.parse(res);
                var parksHTML = '';
                parks.map(function(p) {
                    parksHTML += '<a href="form.php?action=edit&id=' + p.id +'"><div class="media">' +
                                        '<div class="media-left">' +
                                            '<img class="media-object" src="' + p.banner + '">' +
                                        '</div>' +
                                        '<div class="media-body">' +
                                            '<h4 class="media-heading">' + p.name + '</h4>' +
                                        '</div>' +
                                    '</div></a>';
                });
                $('#search-park-result').html(parksHTML);
            }
        });
    });
    
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