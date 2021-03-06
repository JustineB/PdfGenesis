var TEXT_MESSAGE = "<div class='%text_class%'>%text%</div>";

var MODAL = "<div class='modal fade' id='%modal_id%'>" +
    "<div class='modal-dialog' role='document'>" +
    "<div class='modal-content'>" +
    "<div class='modal-header'> %modal_header%  " +
    "<button type='button' class='close' data-dismiss='modal' aria-label='Close'> <span aria-hidden='true'>&times;</span> </button></div>" +
    "<div class='modal-body'> %modal_body% </div>" +
    "<div class='modal-footer'> %modal_footer% </div>" +
    "</div></div></div>";

var BUTTON_MODAL_CLOSE = "<button type='button' class='btn btn-secondary %btn_class%' data-dismiss='modal'>Close</button> ";

var ERROR_TEXT_FORM = "Une erreur c'est produite il est possible que vous n'ayiez pas remplis le formulaire correctement !";

var REGISTER_TEXT_CONFIRMATION = "Un mail de confirmation à été envoyé, merci de confirmer votre compte ! ";

var EMAIL_TEXT_SUCCESS = "Votre email à bien été reconfirmer ! ";

var EMAIL_TEXT_ERROR = "Ce lien à déjà été utilisé ou ne correspond pas à la validation de cet email !";

var CONFIRMATION_REGISTER_CLASS = "confirmation-register";

var EMAIL_UPDATE_CLASS = "email-update-";

var UPDATE_INPUT = "<div class='form-group'>" + "<label for='%input_id%' class='floating-label control-label'/>%label_name%</label>"+
    "<input type='%type_input%' id='%input_id%' name='%input_id%' value='%input_value%' class='form-control'/> %icons_input% </div>";

var SUBMIT_ICON = "<a id='%id_action%'><i class='material-icons'>subdirectory_arrow_left</i></a>";

var EMAIL_UPDATE_WARNING = "<p class='text-warning'> <i class='material-icons'>warning</i> Votre email doit être vérifié ! </p>";