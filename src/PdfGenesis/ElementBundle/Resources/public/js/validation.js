var ERROR_MESSAGE = "<p class='error-message'>%message%</p>"


function emptyInputControl($element){
    var value = $element.val(),
        $parent = $element.parent();

    if($.trim(value).length < 2){
        $parent.css('color',ERROR_RED);
        $parent.append(ERROR_MESSAGE.replace('%message%','deux lettres minimum sont nécessaires'));

        return false;
    }else{
        $parent.css('color',GLOBAL_ICON_COLOR);
        $parent.find('.error-message').remove();

        return true;
    }
}