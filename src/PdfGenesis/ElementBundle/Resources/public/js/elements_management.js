$(document).ready(function(){
    console.log('hrllo');

    $(document).on('dblclick','.element-link',function(){

       var id = $(this).data('id'),
           $element= $('.element-link[data-id="'+id+'"]').find('.element-text');

       inputTransformation($element, id, '.element-text', 'text');
    });


});


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