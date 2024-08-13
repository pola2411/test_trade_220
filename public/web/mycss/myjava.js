
$('#refresh').on('click', function() {
    $('#loading-spinner').show();

    table.ajax.reload(function (){
        $('#alert').css('display', 'none');

                    $('#loading-spinner').hide();

        },false);

});
