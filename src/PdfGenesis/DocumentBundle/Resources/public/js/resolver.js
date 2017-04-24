function resolveErrorForm(){
    var error_text = TEXT_MESSAGE;

    error_text = error_text.replace('%text_class%','alert alert-dismissible alert-danger');
    error_text = error_text.replace('%text%',ERROR_TEXT_FORM);

    return error_text;
}

function updateDocumentModal(data){
    var modal = MODAL,
        btn_close = BUTTON_MODAL_CLOSE;

    btn_close = btn_close.replace('%btn_class%','');

    modal = modal.replace('%modal_id%',UPDATE_DOCUMENT_CLASS+"-"+data.id);
    modal = modal.replace('%modal_header%','Update document');
    modal = modal.replace('%modal_body%',updateContentDocument(data));
    modal = modal.replace('%modal_footer%',btn_close);

    return modal;
}

function updateContentDocument(data){
    var update_content = UPDATE_DOCUMENT_BODY;

    update_content = update_content.replace('%document-id%',data.id);
    update_content = update_content.replace('%document-name%',data.name);
    update_content = update_content.replace('%document-description%',data.description);

    return update_content;
}