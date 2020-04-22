$(document).ready(function() {
    $('select[name=client_id]').select2({
        language: "pt-BR",
        ajax: {
            url: '/admin/client/find',
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
        language: "pt-BR",
        ajax: {
            url: '/admin/contact/find',
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
