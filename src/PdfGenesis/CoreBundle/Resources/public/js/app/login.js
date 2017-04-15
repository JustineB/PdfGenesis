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

function forceLoginChoice(id){
    var tabs_active_class = 'ui-tabs-active ui-state-active';

    $('.ui-tabs-nav li').each(function(){
       $(this).removeClass(tabs_active_class);
       $(this).attr('tabindex','-1');
    });

    $('.ui-tabs-nav li').promise().done(function(){
        var $target = $('.ui-tabs-nav li[aria-labelledby= "'+ id +'"]');

        $target.addClass(tabs_active_class);
        $target.attr('tabindex','0');

        resolverContentLoginChoice($target.attr('aria-controls'));
        resolverLoginChoice(id);
    });
}

function resolverContentLoginChoice(id){

    $('#tabs .ui-tabs-panel').each(function(){
        if($(this).attr('id') == id){
            $(this).attr('aria-hidden','false');
            $(this).css('display','block');
        }else{
            $(this).attr('aria-hidden','true');
            $(this).css('display','none');
        }
    });
}
