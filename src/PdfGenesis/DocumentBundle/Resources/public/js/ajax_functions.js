

function ajaxSaveDocument(){
    $.ajax({
        method: 'POST',
        url: Routing.generate('document_save_ajax'),
        success: function (data) {
            if (data == false) {
                alert(' error ! an error occurs .. ');
            }
        },
        error: function () {
            alert(' error ! an error occurs .. ');
        }
    })
}