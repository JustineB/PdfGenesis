$(document).ready(function(){

    $(".element-part").mouseup(function(){
        $(this).after(ajaxSaveDocument());
    });

    $('.save_document').click(function(){
        ajaxSaveDocument();
    });

    $('.edit-document').click(function(){
       var id = $(this).parent().data('id');

       ajaxGetDocumentData(id,function(output){
           console.log(output['id']);
           callUpdateModal(output);
       });

    });
});



function callUpdateModal(data){
    var html =  updateDocumentModal(data),
        id = data.id,
        $container = $('.document-element-container[data-id="'+id+'"]');

        $container.append(html);

        $('#update-document-'+id).modal('show');
}