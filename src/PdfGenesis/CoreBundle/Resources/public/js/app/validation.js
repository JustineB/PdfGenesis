$(document).ready(function(){

    $(document).on('click','.title-description-validation',function(){
        console.log('aaa');

        var type = $(this).data('type'),
            id = $(this).data('id'),

            $form = $('#form-title-description-'+type+'-'+id);

        $form.submit();
    });

});