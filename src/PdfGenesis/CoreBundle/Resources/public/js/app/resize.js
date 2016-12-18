
interact('.resize-drag')
    .resizable({
        preserveAspectRatio: true,
        edges: {left: true, right: true, bottom: true, top: true},

        onend: function(event){

            console.log(event);

            var target = event.target,
                id = target.getAttribute('data-id');

            ajaxElementSizeChange(id, target.style.width, target.style.height);
            elementPositionResolver(event.target);
        }
    })
    .on('resizemove', function (event) {
        var target = event.target,

            x = (parseFloat(target.getAttribute('data-x')) || 0),
            y = (parseFloat(target.getAttribute('data-y')) || 0);

        // update the element's style
        target.style.width = event.rect.width + 'px';
        target.style.height = event.rect.height + 'px';

        // translate when resizing from top or left edges
        x += event.deltaRect.left;
        y += event.deltaRect.top;

        target.style.webkitTransform = target.style.transform =
            'translate(' + x + 'px,' + y + 'px)';

        target.setAttribute('data-x', x);
        target.setAttribute('data-y', y);
        target.textContent = Math.round(event.rect.width) + '×' + Math.round(event.rect.height);



    });



function ajaxElementSizeChange(id, width, height){

    $.ajax({
       method: 'post',
       url: Routing.generate('element_ajax_size_change'),
       data: {'id' : id, 'width': width, 'height' : height},
       success: function (data) {
           if(data == false){
               alert(' error ! an error occurs .. ');
           }
       },
       error: function(){
           alert(' error ! an error occurs .. ');
       }
    });


}