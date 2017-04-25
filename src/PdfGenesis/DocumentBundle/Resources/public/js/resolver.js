function resolveErrorForm(){
    var error_text = TEXT_MESSAGE;

    error_text = error_text.replace('%text_class%','alert alert-dismissible alert-danger');
    error_text = error_text.replace('%text%',ERROR_TEXT_FORM);

    return error_text;
}

function updateDocumentModal(data){
    var modal = MODAL,
        btn_close = BUTTON_MODAL_CLOSE,
        submit = UPDATE_DOCUMENT_SUBMIT;

    btn_close = btn_close.replace('%btn_class%','');

    submit = submit.replace('%btn_class%','btn-save-document');
    submit = submit.replace('%btn_id%',data.id);

    modal = modal.replace('%modal_id%',UPDATE_DOCUMENT_CLASS+"-"+data.id);
    modal = modal.replace('%modal_class%',UPDATE_DOCUMENT_CLASS);
    modal = modal.replace('%modal_header%','Update document');
    modal = modal.replace('%modal_body%',updateContentDocument(data));
    modal = modal.replace('%modal_footer%',btn_close+ submit);

    return modal;
}

function deleteDocumentModal(id){
    var modal = MODAL,
        btn_close = BUTTON_MODAL_CLOSE,
        delete_submit = DELETE_DOCUMENT_SUBMIT;

    btn_close = btn_close.replace('%btn_class%','');

    delete_submit = delete_submit.replace('%btn_class%','btn-delete-document');
    delete_submit = delete_submit.replace('%btn_id%',id);

    modal = modal.replace('%modal_id%',DELETE_DOCUMENT_CLASS+"-"+id);
    modal = modal.replace('%modal_class%',DELETE_DOCUMENT_CLASS+"-modal");
    modal = modal.replace('%modal_header%','Delete document');
    modal = modal.replace('%modal_body%',DELETE_DOCUMENT_CONTENT);
    modal = modal.replace('%modal_footer%',btn_close+ delete_submit);

    return modal;
}

function updateContentDocument(data){
    var update_content = UPDATE_DOCUMENT_BODY;

    update_content = update_content.replace('%document-id%',data.id);
    update_content = update_content.replace('%document-name%',data.title);
    update_content = update_content.replace('%document-description%',data.description);

    return update_content;
}