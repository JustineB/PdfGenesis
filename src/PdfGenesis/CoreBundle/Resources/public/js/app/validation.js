$(document).ready(function(){

    $(document).on('click','.title-description-validation',function(){

        var type = $(this).data('type'),
            id = $(this).data('id'),

            $form = $('#form-title-description-'+type+'-'+id);

        $form.submit();
    });


    $(document).on('hidden.bs.modal','#'+EMAIL_UPDATE_CLASS, function () {
        $(this).remove();
    });

});


function registrationError(){
    $('#login-modal').modal('show');
    forceLoginChoice('ui-id-2');
    $('#tabs #tabs-2').append(resolveErrorForm());
}

function registrationConfirmation(){
    var modal = confirmationRegistrationModal();
    $('body').append(modal);

    $('body').promise().done(function(){
        $('#'+CONFIRMATION_REGISTER_CLASS).modal('show');
    });
}

function callEmailModal(value){
    var modal = emailUpdateModal(value);
    $('body').append(modal);

    $('body').promise().done(function(){
        $('#'+EMAIL_UPDATE_CLASS).modal('show');
    });
}