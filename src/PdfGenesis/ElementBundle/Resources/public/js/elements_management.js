$(document).ready(function(){


    $(document).on('dblclick','.element-link',function(){

       var id = $(this).data('id'),
           $element= $('.element-link[data-id="'+id+'"]').find('.element-text');

       inputTransformation($element, id, 'element-text', 'text');
    });


    $(document).on('keyup','.element-text-input',function(e){
       var value = $(this).val(),
           id = $(this).data('id');

       console.log($(this).val())

       if(e.keyCode == 13){

           ajaxNameChangeElement(value,id);
           staticTextTransformation($(this),'element-text');

       }
    });


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