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

    $(document).on('click','.change-page-element',function(){
        var id = $(this).data('id');

       getPage(id);
    });

    $(document).on('click','.delete-document',function(){
        var id = $(this).parent().data('id');

        callDeleteModal(id);
    });



    $(document).on('hidden.bs.modal','.update-document', function () {
        $(this).remove();
    });

    $(document).on('hidden.bs.modal','.delete-document-modal', function () {
        $(this).remove();
    });


    $(document).on('click','.btn-save-document',function(){

        var id = $(this).data('id'),
            $form = $('.form-update-document[data-id="'+id+'"]');

        ajaxDocumentUpdate($form, function(output){
           updateDocumentData(output);
        });
    });

    $(document).on('click','.btn-delete-document',function(){

        var id = $(this).data('id');

        ajaxDocumentDelete(id, function(output){
            deleteDocumentData(output);
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

function callDeleteModal(id){
    var html =  deleteDocumentModal(id),
        $container = $('.document-element-container[data-id="'+id+'"]');

        $container.append(html);

        $('#delete-document-'+id).modal('show');
}



function updateDocumentData(data){

    var id = data['id'],
        $container = $('.document-element-container[data-id="'+id+'"]');

    $container.find('.title').text( data['title']);

    $('#update-document-'+id).modal('hide');
}

function deleteDocumentData(data){
    var id = data['id'],
        $container = $('.document-element-container[data-id="'+id+'"]');

    $container.remove();

    $('#delete-document-'+id).modal('hide');
}