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

    $("select[name='client_id'").on('change', function() {
        $("select[name=budget_id]").empty().trigger('change')
    });

});
