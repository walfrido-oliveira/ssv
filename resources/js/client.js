var currentContact = null;

$(document).on('click', ".btn-add", function(e) {
    e.preventDefault();
    $('.select2-with-tag').select2("destroy");

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

    addSelect2();

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

    if(typeof url === 'undefined') {
        removeContact();
        return;
    }

    $.ajax({
        url: url,
        type: 'DELETE',
        data: {
            _token: token,
            id: id
        },
        success: function(response){
            toastr.success(response.message);
            removeContact()
        },
        error: function(err){
            toastr.error(err.responseJSON.message);
        },
    });
});

function removeContact() {
    window.currentContact.remove();
    window.currentContact = null;

    var parents = $('.contact:first').find('.entry')

    for (let index = 0; index < parents.length; index++) {
        const element = parents.eq(index);
        if (index == 0 && parents.length == 1) {
            element.find('.btn-remove').attr('disabled', 'disabled');
            element.find('.btn-add').removeAttr('disabled');
        } else if(index == parents.length -1) {
            element.find('.btn-remove').removeAttr('disabled');
            element.find('.btn-add').removeAttr('disabled');
        } else {
            element.find('.btn-remove').removeAttr('disabled');
            element.find('.btn-add').attr('disabled', 'disabled');
        }
    }

    var scrollTo = $('.contact').find('.entry:last');

    $("html, body").animate({
        scrollTop: scrollTo.offset().top
    }, 500);
}

function addSelect2() {
    $('.select2-with-tag').select2({
        tags: true,
        createTag: function (params) {
            var term = $.trim(params.term);

            if (term === '') {
            return null;
            }

            return {
                id: term,
                text: term
            }
        }
    });
}

$("#search-client-button").click(function() {
    input = $('#client_id').val().replace(/[^0-9]/g,'');

    setFieldsSearchClientModal(false);

    $.ajax({
        type : 'get',
        url : '/admin/clients/cnpj',
        data:{'cnpj':input},
        success:function(data) {
            var result = data.result;
            if (result.status === 'OK') {

                setFieldsSearchClientModal(true);

                setValueSearchClientModal('nome', result.nome);
                setValueSearchClientModal('telefone', result.telefone);
                setValueSearchClientModal('logradouro', result.logradouro);
                setValueSearchClientModal('bairro', result.bairro);
                setValueSearchClientModal('municipio', result.municipio);
                setValueSearchClientModal('uf', result.uf);
                setValueSearchClientModal('numero', result.numero);
                setValueSearchClientModal('cep', result.cep);

            } else {
                alert('Um erro ocorreu ao gerar sua solicitação.')
            }
        },
        fail:function(data) {
            alert(data.message);
        }
    });
});

function setFieldsSearchClientModal( show ) {
    show ? $('#search-client .result').show() : $('#search-client .result').hide();
    show ? $('#search-client .spinner').hide() : $('#search-client .spinner').show()
    $('#search-client .modal-dialog').css('opacity', show ? '1' : '0.9');
    $('#search-client .import').attr('disabled', show ? '' : 'disabled');
}

function getValueSearchClientModal(key) {
    return $('#fieldset-client-modal #' + key).text();
}

function setValueSearchClientModal(key, value) {
    return $('#fieldset-client-modal #' + key).text(value);
}

$("#search-client .import").click(function() {
    ('#razao_social').val(getValueSearchClientModal('nome'));
    ('#phone').val(getValueSearchClientModal('telefone'));
    ('#adress').val(getValueSearchClientModal('logradouro'));
    ('#adress_district').val(getValueSearchClientModal('bairro'));
    ('#adress_city').val(getValueSearchClientModal('municipio'));
    ('#adress_state').val(getValueSearchClientModal('uf'));
    ('#adress_number').val(getValueSearchClientModal('numero'));
    ('#adress_cep').val(getValueSearchClientModal('cep'));
});

$('#search-cep-button').click(function() {
    $(this).find('span').show();
    $(this).find('i').hide();

    input = $('#adress_cep').val().replace(/[^0-9]/g,'');

    $.ajax({
        type : 'get',
        url : '/admin/clients/cep',
        data:{'cep':input},
        success:function(data) {
            var result = data.result;
            console.log(data);
            if (result.status === 'OK') {


            } else {
                alert('Um erro ocorreu ao gerar sua solicitação.')
            }
        },
        fail:function(data) {
            alert(data.message);
        }
    });
});
