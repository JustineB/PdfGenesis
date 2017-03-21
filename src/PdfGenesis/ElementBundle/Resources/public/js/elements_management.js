$(document).ready(function(){

    /** Transform static text in input to allow the name change  */
    $(document).on('dblclick','.element-link',function(){

       var id = $(this).data('id'),
           $element= $('.element-link[data-id="'+id+'"]').find('.element-text');

       inputTransformation($element, id, 'element-text', 'text');
    });

    /** Submit the name's element change  */
    $(document).on('keyup','.element-text-input',function(e){
       var value = $(this).val(),
           id = $(this).data('id');

       if(e.keyCode == 13){
           if(emptyInputControl($(this))){
               ajaxNameChangeElement(value,id);
               staticTextTransformation($(this),'element-text');
           }
       }
    });

    /**  */
    $(document).on('click','.element-part',function(){
       var id= $(this).find('.element-link').data('id');

       focusOnDesignElement(id);
    });


    $(document).on('click','.element-blank-page',function(){
       var id = $(this).data('id');
       focusOnDesignElement(id);
    });


    /** Sort the element list on the tool container */
    $( "#element-list" ).sortable( {out: function( event, ui ) {
        var $list = $('#element-list');

        elementSort($list);
    }} );
});



/*************************************************************************/
/**********************TRANSFORMER*****************************************/
/************************************************************************/

/**
 * Maybe reunir celui d'après avec celui la (Input transf et lui)
 * @param $element
 * @param class_name
 */
function staticTextTransformation($element, class_name){
    var value = $element.val(),
        static_html = staticTextResolver(class_name, value),
        $element_parent = $element.parent();

    $element.remove();
    $element_parent.append(static_html);
}


/**
 *
 * @param $element
 * @param id
 * @param class_name
 * @param input_type
 */
function inputTransformation($element, id, class_name, input_type){

    var value;

    switch(input_type){
        case 'text':
            value = $element.text();
            break;
        default:
            value = "";
            break;
    }

    var input_html = inputResolver(id, class_name, value, input_type),
        $element_parent = $element.parent();

    $element.remove();
    $element_parent.append(input_html);

}


/**
 *
 * @param $list
 */
function elementSort($list){

    var $elements = $list.find('li'),
        z_index = $elements.length,
        id = 0;

    for(var i=0 ; i < $elements.length; i++){

        id = $('#element-list li:eq('+ i +')').find('.element-link').data('id');
        $('.element-blank-page[data-id="'+id+'"]').css('z-index',z_index);
        z_index--;
    }
}

/**
 *
 * @param id
 */
function focusOnDesignElement(id){

    $('.element-blank-page').each(function(){
       $(this).removeClass('element-select');
    });

    $( ".element-blank-page" ).promise().done(function() {
        $('.element-blank-page[data-id="'+id+'"]').addClass('element-select');
    });

}