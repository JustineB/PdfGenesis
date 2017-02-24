


function inputResolver(id, class_name, value, input_type){
    var input = INPUT_TEXT_BUILDER,
        input_res = input.replace("%value%",value );
        input_res = input_res.replace("%class%",class_name );
        input_res = input_res.replace("%id%",id );

    return input_res;
}

function staticTextResolver(class_name, value){
    var input = STATIC_TEXT_BUILDER,
        static_text_res = input.replace("%value%",value );

    static_text_res = static_text_res.replace("%class-static%",class_name );

    return static_text_res;

}