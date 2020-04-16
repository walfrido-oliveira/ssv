$('#delete-modal').on('show.bs.modal', function(e) {

    var id = $(e.relatedTarget).data('id');

    var form = $('#delete-modal-form');
    var action = form.attr('action');
    var newAction = action.replace("#", id);
    form.attr('action', newAction);
});
