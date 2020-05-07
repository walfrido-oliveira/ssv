$(document).ready(function() {

    $('#approve-modal').on('show.bs.modal', function(e) {

        var id = $(e.relatedTarget).data('id');

        var form = $('#approve-modal-form');
        var action = form.attr('action');
        var newAction = action.replace("#", id);
        form.attr('action', newAction);
    });

    $('#disapprove-modal').on('show.bs.modal', function(e) {

        var id = $(e.relatedTarget).data('id');

        var form = $('#disapprove-modal-form');
        var action = form.attr('action');
        var newAction = action.replace("#", id);
        form.attr('action', newAction);
    });

});
