function resolveErrorForm(){
    var error_text = TEXT_MESSAGE;

    error_text = error_text.replace('%text_class%','alert alert-dismissible alert-danger');
    error_text = error_text.replace('%text%',ERROR_TEXT_FORM);

    return error_text;
}

function confirmationRegistrationModal(){
    var modal = MODAL,
        btn_close = BUTTON_MODAL_CLOSE;

    btn_close = btn_close.replace('%btn_class%','');

    modal = modal.replace('%modal_id%',CONFIRMATION_REGISTER_CLASS);
    modal = modal.replace('%modal_header%','Confirmation d\'inscription');
    modal = modal.replace('%modal_body%',REGISTER_TEXT_CONFIRMATION);
    modal = modal.replace('%modal_footer%',btn_close);

    return modal;
}