$(document).ready(function(){
    $(document).on('change','#import-file #import_path', function(){
        if($(this).get(0).files.length > 0){
            $('#import-file').submit();
        }
    });

    $(document).on('change','#picture-download-form #picture-download-input', function(){
        if($(this).get(0).files.length > 0){
            $('#picture-download-form').submit();
        }
    });
});