var currentContact = null;

$(document).on('click', ".btn-add", function(e) {
    e.preventDefault();

    var controlContact = $('.contact:first'),
        currentEntry   = $(this).parents('.entry:first'),
        newEntry       = $(currentEntry.clone()).appendTo('.contact:first');

    newEntry.find('input').val('');

    var selector = newEntry.find('input').attr('name');
    var index_value = selector.match(/\d+/)[0];

    var nextIndexValue = parseInt(index_value,10)+1;

    newEntry.find('input,select').each(function(){
        this.name = this.name.replace(selector.match(/\d+/)[0],nextIndexValue)
    });

    controlContact.find('.entry:not(:last) .btn-remove')
        .removeAttr('disabled');

    controlContact.find('.entry:not(:last) .btn-add')
        .attr('disabled', 'disabled');

    newEntry.find('.btn-remove')
        .removeAttr('disabled');

    newEntry.find('.btn-add')
        .removeAttr('disabled');

}).on('click', '.btn-remove', function(e) {

    window.currentContact = $(this).parents('.entry:first');

    $('#delete-modal').modal('show');

    e.preventDefault();
});

$('#delete-modal').on('show.bs.modal', function(e) {

    var id = $(e.relatedTarget).data('id');
    var url = $(e.relatedTarget).data('url');

    $('#btn-modal-delete-yes').attr('data-id', id).attr('data-url', url);
});


$(document).on('click', "#btn-modal-delete-yes", function(e) {

    $('#delete-modal').modal('hide');

    var id = $(this).data('id');
    var url = $(this).data('url');
    var token = $("meta[name='csrf-token']").attr("content");

    $.ajax({
        url: url,
        type: 'DELETE',
        data: {
            _token: token,
            id: id
        },
        success: function(response){
            toastr.success(response.message);

            var parents = $('.contact:first').find('.entry')

            if (parents.length == 1) {
                parents.eq(0).find('.btn-remove').attr('disabled', 'disabled');
                return;
            }

            if (parents.length == 2) {
                parents.eq(0).find('.btn-remove').attr('disabled', 'disabled');
                parents.eq(0).find('.btn-add').removeAttr('disabled');
            }

            window.currentContact.remove();
            window.currentContact = null;

            var container = $("html,body");
            var scrollTo = $('.contact').find('.entry:last');

            $("html, body").animate({
                scrollTop: scrollTo.offset().top
            }, 500);    //scrollTop(scrollTo.offset().top);

        }
    });
});


