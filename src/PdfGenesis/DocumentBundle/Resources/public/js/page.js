function getPage(id){

    $.ajax({
        method: "post",
        url: Routing.generate('document_get_page_ajax'),
        data: {'id' : id},
        success: function(data){
            console.log(data);
            $('#page-view').empty();

            $('#page-view').promise().done(function(){
               $(this).append(data);
                changeActivePage(id);
            });


        },
        error: function(){
            console.log('error de chargement de page');
        }
    })
}

function changeActivePage(id){
    $('.page-icon').each(function(){
       $(this).removeClass('active');
    });

    $('.page-icon').promise().done(function(){
        $('.change-page-element[data-id="'+id+'"]').find('.page-icon').addClass('active');
    });
}