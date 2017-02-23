


function inputResolver(id, class_name, value, input_type){
    var input = INPUT_TEXT_BUILDER,
        input_res = input.replace("%value%",value );
        input_res = input_res.replace("%class%",class_name );
        input_res = input_res.replace("%id%",id );

    return input_res;
}