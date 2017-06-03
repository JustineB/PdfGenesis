

function ajaxSaveDocument(){
    $.ajax({
        method: 'POST',
        url: Routing.generate('document_save_ajax'),
        success: function (data) {
            if (data != false) {
                var page_id = data.id,
                    $page_element = $('.page_element[data-id="'+page_id+'"]');

                $page_element.empty();
                $page_element.append(data.view);

                console.log(data);
            }
        },
        error: function () {
            alert(' error ! an error occurs .. ');
        }
    })
}

function ajaxGetDocumentData(id,handleData){
    $.ajax({
        method: 'POST',
        url: Routing.generate('document_data_ajax'),
        data: {'id' : id},
        dataType: "json",
        success: function (data) {
            if (data != false) {
                handleData(data);
            }
        },
        error: function () {
            alert(' error ! an error occurs .. ');
        }

    });
}


function ajaxDocumentUpdate($form,handleData){
    $.ajax({
        method: 'POST',
        url: Routing.generate('document_update_ajax'),
        data: {'id' : $form.data('id'),
        'title':$form.find('#name').val() ,
        'description':$form.find('#description').val() },
        success: function (data) {
            if (data != false) {
                handleData(data);
            }
        },
        error: function () {
            alert(' error ! an error occurs .. ');
        }

    });
}

function ajaxDocumentDelete(id,handleData){
    $.ajax({
        method: 'POST',
        url: Routing.generate('document_delete_ajax'),
        data: {'id' : id },
        success: function (data) {
            if (data != false) {
                handleData(data);
            }
        },
        error: function () {
            alert(' error ! an error occurs .. ');
        }

    });
}

