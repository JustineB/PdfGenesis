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
           callUpdateModal(output);
       });

    });

    $(document).on('hidden.bs.modal','.update-document', function () {
        $(this).remove();
    });

    $(document).on('click','.btn-save-document',function(){

        var id = $(this).data('id'),
            $form = $('.form-update-document[data-id="'+id+'"]');


        ajaxDocumentUpdate($form, function(output){
           updateDocumentData(output);
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


function updateDocumentData(data){
    console.log(data);
    var id = data['id'],
        $container = $('.document-element-container[data-id="'+id+'"]');

    $container.find('.title').text( data['title']);

    $('#update-document-'+id).modal('hide');
}