var TEXT_MESSAGE = "<div class='%text_class%'>%text%</div>";

var MODAL = "<div class='modal fade %modal_class%' id='%modal_id%'>" +
    "<div class='modal-dialog' role='document'>" +
    "<div class='modal-content'>" +
    "<div class='modal-header'> %modal_header%  " +
    "<button type='button' class='close' data-dismiss='modal' aria-label='Close'> <span aria-hidden='true'>&times;</span> </button></div>" +
    "<div class='modal-body'> %modal_body% </div>" +
    "<div class='modal-footer'> %modal_footer% </div>" +
    "</div></div></div>";

var BUTTON_MODAL_CLOSE = "<button type='button' class='btn btn-secondary %btn_class%' data-dismiss='modal'>Close</button> ";

var ERROR_TEXT_FORM = "Une erreur c'est produite il est possible que vous n'ayiez pas remplis le formulaire correctement !";

var UPDATE_DOCUMENT_BODY = "<form action='' method='post' class='form-horizontal form-update-document form form-modal' data-id='%document-id%' xmlns='http://www.w3.org/1999/html'> <div class='inputs'> "+
                                "<div class='form-group'> <label for='name' class='floating-label control-label'>Titre</label>"+
                                "<input type='text' id='name' name='_name' class='form-control' value='%document-name%' required='required' />"+
                                "</div> <div class='form-group'> <label for='description' class='floating-label control-label'>Description</label>"+
                                "<textarea  id='description' class='form-control' name='_description' required='required' > %document-description% </textarea>"+
                                "</div> </div> </form> ";

var UPDATE_DOCUMENT_CLASS = "update-document";

var UPDATE_DOCUMENT_SUBMIT = "<button type='button' class='btn btn-secondary %btn_class%' data-dismiss='modal' data-id='%btn_id%'>Save</button>";

