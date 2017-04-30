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

function emailUpdateInput(value, id){
    var input = UPDATE_INPUT,
        submit_icon = SUBMIT_ICON;

    submit_icon = submit_icon.replace('%id_action%','email-user-submit');

    input = input.replace('%label_name%','email :');
    input = input.replace('%type_input%','text');
    input = input.replace(/'%input_id%'/g,id);
    input = input.replace('%input_value%',value);
    input = input.replace('%icons_input%',submit_icon);

    return input;

}

