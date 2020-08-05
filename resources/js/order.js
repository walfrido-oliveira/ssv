$(document).ready(function() {

    $('select[name=client_id]').select2({
        language: "pt-BR",
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

    $('select[name=budget_id]').select2({
        language: "pt-BR",
        ajax: {
            url: '/admin/budgets/find',
            dataType: 'json',
            data: function (params) {
                var query = {
                    q: $.trim(params.term),
                    client_id: $("select[name='client_id'").val(),
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

    $('select[name=service]').select2({
        language: "pt-BR",
        ajax: {
            url: '/admin/budgets/find-service',
            dataType: 'json',
            data: function (params) {
                var query = {
                    q: $.trim(params.term),
                    budget_id: $("select[name='budget_id'").val(),
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

    $('select[name=service_type]').select2({
        language: "pt-BR",
        ajax: {
            url: '/admin/service-types/find',
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

    $("select[name='client_id'").on('change', function() {
        $("select[name=budget_id]").empty().trigger('change');
    });

    $('.btn-add-service').on('click', function(e) {
        var tbody = $('.table-service tbody');

        var service = $('select[name=service]').select2('data')[0];
        var serviceType = $('select[name=service_type]').select2('data')[0];
        var executedAt = $('input[name=executed_at]').val();
        var equipmentId = $('input[name=equipment_id]').val();
        var description = $('textarea[name=description]').val();

        var index = tbody.find('tr').length + 1;

        var row = '<tr id="row-service-' + (index-1) + '">' +
                  '<td>' + index +
                  '<input type="hidden" name="services[' + (index-1) + '][budget_service_id]" value="' + service.id + '" />'+
                  '<input type="hidden" name="services[' + (index-1) + '][service_type_id]" value="' + (index-1) + '" />'+
                  '<input type="hidden" name="services[' + (index-1) + '][index]" value="' + (index-1) + '" />'+
                  '</td>' +
                  '<td>' + service.name + '<input type="hidden" name="services[' + (index-1) + '][service_name]" value="' + service.name + '" /></td>' +
                  '<td>' + dateToDMY(new Date(executedAt)) + '<input type="hidden" name="services[' + (index-1) + '][executed_at]" value="' + executedAt + '" /></td>' +
                  '<td>' + equipmentId + '<input type="hidden" name="services[' + (index-1) + '][equipment_id]" value="' + equipmentId + '" /></td>' +
                  '<td>' + serviceType.name + '<input type="hidden" name="services[' + (index-1) + '][service_type_name]" value="' + serviceType.name + '" /></td>' +
                  '<td>' + description + '<input type="hidden" name="services[' + (index-1) + '][description]" value="' + description + '" /></td>' +
                  '<td width="15%">' +
                  '<a href="#" class="btn btn-danger btn-sm btn-remove-service" data-toggle="modal" data-target="#delete-modal" data-row="row-service-' + (index-1) + '">' +
                  '<i class="fas fa-trash-alt"></i>' +
                  '</a>' +
                  '</tr>';

        tbody.append(row);

        $('select[name=service]').val(null).trigger("change");
        $('#service-modal').modal('hide');

    });

    $('input[name=executed_at]').on('change', function() {

    });

    $('.add-service').on('click', function() {
        clearServiceModal();
    });

    function clearServiceModal() {
        $("select[name=service]").empty().trigger('change');
        $("select[name=service_type]").empty().trigger('change');
        let $executeAt = $('input[name=executed_at]');
        $executeAt.val('');
        $executeAt.attr('type', 'text');
        $('input[name=equipment_id]').val('');
        $('textarea[name=description]').val('');
    }

});
