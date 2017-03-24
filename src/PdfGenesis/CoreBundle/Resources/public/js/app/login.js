$(document).ready(function(){


    $(document).on('click','.login-action a',function(){
        var id = $('#tabs .ui-tabs-active a').attr('id');
        resolverLoginChoice(id);
    });


   $(document).on('click','#login-modal .ui-tabs-tab a',function(){
       var id = $(this).attr('id');
       resolverLoginChoice(id);
   });
});


function resolverLoginChoice(id){
    $('#login-table-choices li').each(function(){
        if($(this).attr('id') == id){
            $(this).addClass('active');
        }else{
            $(this).removeClass('active');
        }
    });
}