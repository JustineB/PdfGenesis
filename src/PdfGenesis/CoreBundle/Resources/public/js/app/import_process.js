$(document).ready(function(){
    $(document).on('change','#import-file #import_path', function(){
        if($(this).get(0).files.length > 0){
            $('#import-file').submit();
        }
    });
});