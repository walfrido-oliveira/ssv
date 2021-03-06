$(document).ready(function() {

    calcTotalBudget();

    $('select[name=client_id]').select2({
        language: "pt-BR",
        theme: 'bootstrap4',
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
        language: "pt-BR",
        theme: 'bootstrap4',
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
        language: "pt-BR",
        theme: 'bootstrap4',
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
                    results: $.map(data, function(item) {
                        return {
                            text: item.text,
                            id: item.id,
                            price: item.price
                        }
                    }),
                    pagination: {
                        more: (params.page * 30) < data.total_count
                    }
                };
            },
            cache: true
        },
        templateResult: formatService,
        templateSelection: formatServiceSelection
    });

    $('select[name=product]').select2({
        language: "pt-BR",
        theme: 'bootstrap4',
        ajax: {
            url: '/admin/products/find',
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
        },
        templateResult: formatProduct,
        templateSelection: formatProductSelection
    });

    $('.btn-add-service').on('click', function(e) {
        var tbody = $('.table-service tbody');

        var service = $('select[name=service]').find(':selected');

        var data = $('select[name=service]').select2('data')[0];

        var amount = $('input[name=service_amount]');

        var index = tbody.find('tr').length + 1;

        var row = '<tr id="row-service-' + (index-1) + '">' +
                  '<td>' + index +
                  '<input type="hidden" name="services[' + (index-1) + '][service_id]" value="' + service.val() + '" />'+
                  '<input type="hidden" name="services[' + (index-1) + '][index]" value="' + (index-1) + '" />'+
                  '</td>' +
                  '<td>' + service.text() + '<input type="hidden" name="services[' + (index-1) + '][service_name]" value="' + service.text() + '" /></td>' +
                  '<td>' + window.currencyFormatDE(data.price) + '<input type="hidden" name="services[' + (index-1) + '][service_price]" value="' + data.price + '" /></td>' +
                  '<td>' + amount.val() + '<input type="hidden" name="services[' + (index-1) + '][amount]" value="' + amount.val() + '" /></td>' +
                  '<td class="total-service-item">' + window.currencyFormatDE(amount.val() * data.price) + '<input type="hidden" name="services[' + (index-1) + '][total]" value="' + amount.val() * data.price + '" /></td>' +
                  '<td width="15%">' +
                  '<div class="btn-group">' +
                  '<a href="#" class="btn btn-danger btn-sm btn-remove-service" data-toggle="modal" data-target="#delete-modal" data-row="row-service-' + (index-1) + '">' +
                  '<i class="fas fa-trash-alt"></i>' +
                  '</a>' +
                  '</div>'
                  '</td>'
                  '</tr>';

        tbody.append(row);

        calcTotalBudget();

        $('select[name=service]').val(null).trigger("change");
        amount.val(1);

        $('#service-modal').modal('hide');

    });

    $('.btn-add-product').on('click', function(e) {
        var tbody = $('.table-product tbody');

        var product = $('select[name=product]').find(':selected');

        var data = $('select[name=product]').select2('data')[0];

        var amount = $('input[name=product_amount]');

        var index = tbody.find('tr').length + 1;

        var row = '<tr id="row-product-' + (index-1) + '">' +
                  '<td>' + index +
                  '<input type="hidden" name="products[' + (index-1) + '][product_id]" value="' + product.val() + '" />' +
                  '<input type="hidden" name="products[' + (index-1) + '][index]" value="' + (index-1) + '" />' +
                  '</td>' +
                  '<td>' + product.text() + '<input type="hidden" name="products[' + (index-1) + '][product_name]" value="' + product.text() + '" /></td>' +
                  '<td>' + window.currencyFormatDE(data.price) + '<input type="hidden" name="products[' + (index-1) + '][product_price]" value="' + data.price + '" /></td>' +
                  '<td>' + amount.val() + '<input type="hidden" name="products[' + (index-1) + '][amount]" value="' + amount.val() + '" /></td>' +
                  '<td class="total-product-item">' + window.currencyFormatDE(amount.val() * data.price) + '<input type="hidden" name="products[' + (index-1) + '][total]" value="' + amount.val() * data.price + '" /></td>' +
                  '<td width="15%">' +
                  '<div class="btn-group">' +
                  '<a href="#" class="btn btn-danger btn-sm btn-remove-product" data-toggle="modal" data-target="#delete-modal" data-row="row-product-' + (index-1) + '">' +
                  '<i class="fas fa-trash-alt"></i>' +
                  '</a>' +
                  '</div>'
                  '</tr>';

        tbody.append(row);

        calcTotalBudget();

        $('select[name=product]').val(null).trigger("change");
        amount.val(1);

        $('#product-modal').modal('hide');

    });

    $('.btn-cancel').on('click', function(e) {
        $('select[name=service]').val(null).trigger("change");
        $('input[name=service_amount]').val(1);
        $('select[name=product]').val(null).trigger("change");
        $('input[name=product_amount]').val(1);
    });

    $('#delete-modal').on('show.bs.modal', function(e) {
        var row = $(e.relatedTarget).data('row');
        $('.btn-delete').attr('data-row', row);
    });

    $('.btn-delete').on('click', function(e) {
        var row = $(this).attr('data-row');
        $('#' + row).remove();
        calcTotalBudget();
        $('#delete-modal').modal('hide');
    });
});

function formatContact(contact) {

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

function formatService(service) {
    if (service.loading) {
        return service.text;
    }

    var $container = $(
        "<div class='select2-result-service clearfix'>" +
          "<div class='select2-result-service__meta'>" +
            "<div class='select2-result-service__name'></div>" +
          "</div>" +
        "</div>"
    );

    $container.find(".select2-result-service__name").text(service.text + ' - ' + window.currencyFormatDE(service.price));

    return $container;
}

function formatProduct(product) {
    if (product.loading) {
        return product.text;
    }

    var $container = $(
        "<div class='select2-result-product clearfix'>" +
          "<div class='select2-result-product__meta'>" +
            "<div class='select2-result-product__name'></div>" +
          "</div>" +
        "</div>"
    );

    $container.find(".select2-result-product__name").text(product.text + ' - ' + window.currencyFormatDE(product.price));

    return $container;
}

function formatContactSelection(contact) {
    var name =  contact.contact;
    var email = contact.email;
    if (!name) name = '';
    if (!email) email = '';
    return name != '' || email != ''  ?  (name + ' - ' + email)  : contact.text;
}

function formatServiceSelection(service) {
    var name = service.text;
    var price = service.price;
    return  !isNaN(price) ? name + ' - ' + window.currencyFormatDE(price) : service.text;
}

function formatProductSelection(product) {
    var name = product.text;
    var price = product.price;
    return  !isNaN(price) ? name + ' - ' + window.currencyFormatDE(price) : product.text;
}

function calTotalService() {
    var sum = 0;
    $('.total-service-item input').each(function(){
        sum += parseFloat($(this).val());
    })
    $('.total-services').text(window.currencyFormatDE(sum));
    return sum;
}

function calcTotalProduct() {
    var sum = 0;
    $('.total-product-item input').each(function(){
        sum += parseFloat($(this).val());
    })
    $('.total-products').text(window.currencyFormatDE(sum));
    return sum;
}

function calcTotalBudget() {
    $('.total-budget').text(window.currencyFormatDE(calTotalService()+calcTotalProduct()));
}

