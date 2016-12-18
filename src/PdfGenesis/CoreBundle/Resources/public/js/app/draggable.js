interact('.resize-drag')
    .draggable({
        // enable inertial throwing
        inertia: true,
        // keep the element within the area of it's parent
        restrict: {
            restriction: "parent",
            endOnly: true,
            elementRect: {top: 0, left: 0, bottom: 1, right: 1}
        },
        // enable autoScroll
        autoScroll: true,

        // call this function on every dragmove event
        onmove: dragMoveListener,
        // call this function on every dragend event
        onend: function (event) {
            var textEl = event.target.querySelector('p');

            textEl && (textEl.textContent =
                'moved a distance of '
                + (Math.sqrt(event.dx * event.dx +
                    event.dy * event.dy) | 0) + 'px');

            elementPositionResolver(event.target);
        }
    });

/**
 *
 * @param event
 */
function dragMoveListener(event) {
    var target = event.target,
        // keep the dragged position in the data-x/data-y attributes
        x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx,
        y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;

    // translate the element
    target.style.webkitTransform =
        target.style.transform =
            'translate(' + x + 'px, ' + y + 'px)';

    // update the posiion attributes
    target.setAttribute('data-x', x);
    target.setAttribute('data-y', y);
}

// this is used later in the resizing and gesture demos
window.dragMoveListener = dragMoveListener;


/**
 *
 * @param target
 */
function elementPositionResolver(target) {

    var id = target.getAttribute('data-id'),

        y_init = pxToIntConverter(target.style.top),
        x_init = pxToIntConverter(target.style.left),

        y_diff = parseInt(target.getAttribute('data-y')),
        x_diff = parseInt(target.getAttribute('data-x')),

        x_new = x_init + x_diff,
        y_new = y_init + y_diff;

    ajaxElementPositionChange(id, x_new, y_new);
}


/**
 *
 * @param id
 * @param x
 * @param y
 */
function ajaxElementPositionChange(id, x, y) {


    $.ajax({
        method: 'post',
        url: Routing.generate('element_ajax_position_change'),
        data: {'id': id, 'x': x, 'y': y},
        success: function (data) {
            if (data == false) {
                alert('Une erreur c\'est produite veuillez nous excusez !');
            }
        },
        error: function () {
            alert('Une erreur c\'est produite veuillez nous excusez !');
        }
    });
}



