/**********************************************************************/
/**********************AJAX********************************************/
/**********************************************************************/


function ajaxNameChangeElement(value,id){
    $.ajax({
        method: 'POST',
        url: Routing.generate('element_ajax_name_change'),
        data: {'id': id, 'name': value},
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