var $USER_EMAIL_DIV = $('#email-user');


$(document).ready(function(){


    $(document).on('click','#email-user-edit',function(){
        var value = $(this).data('value'),
            html  = emailUpdateInput(value, 'email-user-edit-input');

        $('.data ul').append("<li id='email-edit' >"+html+"</li>");

        $USER_EMAIL_DIV.hide();
    });

    $(document).on('click','#email-user-submit',function(){
        emailUpdateAction();
    });


    $(document).on('keyup','#email-edit',function(e){
        if(e.keyCode == 13){
            emailUpdateAction();
        }
    });

});

function emailUpdateAction(){
    var value_email = $('#email-user-edit-input').val();

    ajaxUserUpdateEmail(value_email);
    changeEmailValue(value_email);

    $('#email-edit').remove();
    $USER_EMAIL_DIV.show();
}

function ajaxUserUpdateEmail(value_email){

    $.ajax({
        method: 'POST',
        url: Routing.generate('user_ajax_update'),
        data: {'email': value_email},
        success: function(data){
            if(data == false){
                console.log('une erreur est survenue !');
            }
        },
        error: function(){
            console.log('une erreur est survenue !');
        }

    });
}

function changeEmailValue(value){

    if($('#email-user-edit').data('value') != value){
        $USER_EMAIL_DIV.find('p').remove();
        $(EMAIL_UPDATE_WARNING).insertBefore( $USER_EMAIL_DIV.find('strong') );
    }

    $USER_EMAIL_DIV.find('text').text(value);
    $('#email-user-edit').data('value',value);
}