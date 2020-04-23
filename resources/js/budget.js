$(document).ready(function() {
    $('select[name=client_id]').select2({
        ajax: {
            url: '/admin/clients/find',
            dataType: 'json',
            data: function (params) {
                var query = {
                    q: $.trim(params.term),
                    page: params.page
                }
                return query;
            },
            processResults: function (data, params) {
                params.page = params.page || 1;

                return {
                    results: data,
                    pagination: {
                        more: (params.page * 30) < data.total_count
                    }
                };
            },
            cache: true
        }
    });

    $('select[name=client_id]').on('change', function (e) {
        $('select[name=client_contact_id]').val(null).trigger('change');
    });

    $('select[name=client_contact_id]').select2({
        ajax: {
            url: '/admin/contacts/find',
            dataType: 'json',
            data: function (params) {
                var query = {
                    q: $.trim(params.term),
                    client_id: $('select[name=client_id').find(':selected').val(),
                    page: params.page
                }
                return query;
            },
            processResults: function (data, params) {
                params.page = params.page || 1;

                return {
                    results: data,
                    pagination: {
                        more: (params.page * 30) < data.total_count
                    }
                };
            },
            cache: true
        },
        templateResult: formatContact,
        templateSelection: formatContactSelection
    });

    $('select[name=service]').select2({
        ajax: {
            url: '/admin/services/find',
            dataType: 'json',
            data: function (params) {
                var query = {
                    q: $.trim(params.term),
                    page: params.page
                }
                return query;
            },
            processResults: function (data, params) {
                params.page = params.page || 1;

                return {
                    results: data,
                    pagination: {
                        more: (params.page * 30) < data.total_count
                    }
                };
            },
            cache: true
        }
    });

    $('.btn-add-service').on('click', function(e) {
        var tbody = $('.table-service tbody');

        var service = $('select[name=service]').find(':selected');

        var amount = $('input[name=service_amount]');

        var index = tbody.find('tr').length + 1;

        var row = '<tr id="row-service-' + (index-1) + '">' +
                  '<td>' + index + '</td>' +
                  '<td>' + service.text() + '<input type="hidden" name="services[' + (index-1) + '][service_id]" value="' + service.val() + '" /></td>' +
                  '<td>' + amount.val() + '<input type="hidden" name="services[' + (index-1) + '][amount]" value="' + amount.val() + '" /></td>' +
                  '<td width="15%">' +
                  '<a href="#" class="btn btn-danger btn-sm btn-remove-service" data-toggle="modal" data-target="#delete-modal" data-row="' + (index-1) + '">' +
                  '<i class="fas fa-trash-alt"></i>' +
                  '</a>' +
                  '</tr>';

        tbody.append(row);

        $('select[name=service]').val(null).trigger("change");
        amount.val(1);

        $('#service-modal').modal('hide');

    });

    $('#delete-modal').on('show.bs.modal', function(e) {
        var row = $(e.relatedTarget).data('row');
        $('.btn-delete-service').attr('data-row', row);
    });

    $('.btn-cancel').on('click', function(e) {
        $('select[name=service]').val(null).trigger("change");
        $('input[name=service_amount]').val(1);
    });

    $('.btn-delete-service').on('click', function(e) {
        var row = $(this).data('row');
        $('#row-service-'+row).remove();
        $('#delete-modal').modal('hide');
    });
});

function formatContact (contact) {

    if (contact.loading) {
      return contact.text;
    }

    var $container = $(
      "<div class='select2-result-contact clearfix'>" +
        "<div class='select2-result-contact__meta'>" +
          "<div class='select2-result-contact__contact'></div>" +
          "<div class='select2-result-contact__department'></div>" +
          "<div class='select2-result-contact__phone'></div>" +
          "<div class='select2-result-contact__mobile_phone'></div>" +
          "<div class='select2-result-contact__email'></div>" +
        "</div>" +
      "</div>"
    );

    $container.find(".select2-result-contact__contact").text(contact.contact);
    $container.find(".select2-result-contact__department").text(contact.department);
    $container.find(".select2-result-contact__phone").text(contact.phone);
    $container.find(".select2-result-contact__mobile_phone").text(contact.mobile_phone);
    $container.find(".select2-result-contact__email").text(contact.email);

    return $container;
  }

  function formatContactSelection (contact) {
    var name =  contact.contact;
    var email = contact.email;
    if (!name) name = '';
    if (!email) email = '';
    return name != '' || email != ''  ?  (name + ' - ' + email)  : contact.text;
  }
