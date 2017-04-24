

function ajaxSaveDocument(){
    $.ajax({
        method: 'POST',
        url: Routing.generate('document_save_ajax'),
        success: function (data) {
            if (data == false) {
                console.log(' error ! an error occurs .. ');
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
