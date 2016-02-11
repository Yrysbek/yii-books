$(function(){
    $(document).on('click', 'table tr td:last-child a, .btn.create-book', function(e){
        e.preventDefault();
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('href'));
        document.getElementById('modalHeader').innerHTML = '<h4>' + $(this).attr('title') + '</h4>';
    });

    $(document).on('click', 'table img', function(e){
        $('#modal').modal('show')
                .find('#modalContent')
                .html('<img src="'+$(this).attr('src')+'" />');
        document.getElementById('modalHeader').innerHTML = '<h4>' + $(this).attr('alt') + '</h4>';
    });
});