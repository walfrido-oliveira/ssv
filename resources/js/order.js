$(document).ready(function() {

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

    $('select[name=budget_id]').select2({
        language: "pt-BR",
        theme: 'bootstrap4',
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
        theme: 'bootstrap4',
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

    $('select[name=product]').select2({
        language: "pt-BR",
        theme: 'bootstrap4',
        ajax: {
            url: '/admin/budgets/find-product',
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
        theme: 'bootstrap4',
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

    $('.btn-add-service').on('click', function() {
        if (!ceckServiceValues()) return;

        let dataRow = $(this).attr('data-row');

        let tbody = $('.table-service tbody');

        let service = $('select[name=service]').select2('data')[0];
        let serviceType = $('select[name=service_type]').select2('data')[0];
        let executedAt = $('input[name=executed_at]').val();
        let equipmentId = $('input[name=equipment_id]').val();
        let description = $('textarea[name=service-description]').val();

        let index = tbody.find('tr').length;

        if (!dataRow) {
            index++;

            let row = '<tr id="row-service-' + (index-1) + '" data-row="' + (index-1) + '">' +
            '<td>' + index +
            '<input type="hidden" name="services[' + (index-1) + '][budget_service_id]" value="' + service.id + '" />'+
            '<input type="hidden" name="services[' + (index-1) + '][service_type_id]" value="' + serviceType.id + '" />'+
            '<input type="hidden" name="services[' + (index-1) + '][index]" value="' + (index-1) + '" />'+
            '</td>' +
            '<td>' + service.name + '<input type="hidden" name="services[' + (index-1) + '][service_name]" value="' + service.name + '" /></td>' +
            '<td>' + dateToDMY(executedAt) + '<input type="hidden" name="services[' + (index-1) + '][executed_at]" value="' + executedAt + '" /></td>' +
            '<td>' + equipmentId + '<input type="hidden" name="services[' + (index-1) + '][equipment_id]" value="' + equipmentId + '" /></td>' +
            '<td>' + serviceType.name + '<input type="hidden" name="services[' + (index-1) + '][service_type_name]" value="' + serviceType.name + '" /></td>' +
            '<td>' + description + '<input type="hidden" name="services[' + (index-1) + '][description]" value="' + description + '" /></td>' +
            '<td>' + CURRENT_USER + '</td>' +
            '<td width="15%">' +
            '<div class="btn-group">' +
            '<a href="#" class="btn-secondary btn-sm btn-edit-service" data-toggle="modal" data-target="#service-modal" data-row="row-service-' + (index-1) + '">' +
            '<i class="fas fa-pencil-alt"></i>' +
            '</a>' +
            '</div>&nbsp;' +
            '<div class="btn-group">' +
            '<a href="#" class="btn btn-danger btn-sm btn-remove-service" data-toggle="modal" data-target="#delete-modal" data-row="row-service-' + (index-1) + '">' +
            '<i class="fas fa-trash-alt"></i>' +
            '</a>' +
            '</div>' +
            '</td>' +
            '</tr>';
            tbody.append(row);
        } else {
            let $row = $('#' + dataRow);
            index = $row.index();

            let $serviceId = $("input[name='services[" + index + "][budget_service_id]']");
            let $serviceName = $("input[name='services[" + index + "][service_name]']");

            let $serviceTypeId = $("input[name='services[" + index + "][service_type_id]']");
            let $serviceTypeName = $("input[name='services[" + index + "][service_type_name]']");

            let $executedAt = $("input[name='services[" + index + "][executed_at]']");
            let $equipmentId = $("input[name='services[" + index + "][equipment_id]']");
            let $description = $("input[name='services[" + index + "][description]']");

            $serviceId.val(service.id);

            $serviceName.val(service.text);
            $serviceNameParent = $serviceName.parent();
            $serviceNameParent.text('').append($serviceName).append(service.text);

            $serviceTypeId.val(serviceType.id);

            $serviceTypeName.val(serviceType.text);
            $serviceTypeNameParent = $serviceTypeName.parent();
            $serviceTypeNameParent.text('').append($serviceTypeName).append(serviceType.text);

            $executedAt.val(executedAt);
            $executedAtParent = $executedAt.parent();
            $executedAtParent.text('').append($executedAt).append(dateToDMY(executedAt));

            $equipmentId.val(equipmentId);
            $equipmentIdParent = $equipmentId.parent();
            $equipmentIdParent.text('').append($equipmentId).append(equipmentId);

            $description.val(description);
            $descriptionParent = $description.parent();
            $descriptionParent.text('').append($description).append(description);
        }

        $('select[name=service]').val(null).trigger("change");
        $('#service-modal').modal('hide');

    });

    $('.btn-add-product').on('click', function() {
        if (!ceckProductValues()) return;

        let dataRow = $(this).attr('data-row');

        let tbody = $('.table-product tbody');

        let product = $('select[name=product]').select2('data')[0];
        let description = $('textarea[name=product-description]').val();

        let index = tbody.find('tr').length;

        if (!dataRow) {
            index++;

            let row = '<tr id="row-product-' + (index-1) + '" data-row="' + (index-1) + '">' +
            '<td>' + index +
            '<input type="hidden" name="products[' + (index-1) + '][budget_product_id]" value="' + product.id + '" />'+
            '<input type="hidden" name="products[' + (index-1) + '][index]" value="' + (index-1) + '" />'+
            '</td>' +
            '<td>' + product.name + '<input type="hidden" name="products[' + (index-1) + '][product_name]" value="' + product.name + '" /></td>' +
            '<td>' + description + '<input type="hidden" name="products[' + (index-1) + '][description]" value="' + description + '" /></td>' +
            '<td>' + CURRENT_USER + '</td>' +
            '<td width="15%">' +
            '<div class="btn-group">' +
            '<a href="#" class="btn-secondary btn-sm btn-edit-product" data-toggle="modal" data-target="#product-modal" data-row="row-product-' + (index-1) + '">' +
            '<i class="fas fa-pencil-alt"></i>' +
            '</a>' +
            '</div>&nbsp;' +
            '<div class="btn-group">' +
            '<a href="#" class="btn btn-danger btn-sm btn-remove-product" data-toggle="modal" data-target="#delete-modal" data-row="row-product-' + (index-1) + '">' +
            '<i class="fas fa-trash-alt"></i>' +
            '</a>' +
            '</div>' +
            '</td>' +
            '</tr>';
            tbody.append(row);
        } else {
            let $row = $('#' + dataRow);
            index = $row.index();

            let $productId = $("input[name='products[" + index + "][budget_product_id]']");
            let $productName = $("input[name='products[" + index + "][product_name]']");

            let $description = $("input[name='products[" + index + "][description]']");

            $productId.val(product.id);

            $productName.val(product.text);
            $productNameParent = $productName.parent();
            $productNameParent.text('').append($productName).append(product.text);

            $description.val(description);
            $descriptionParent = $description.parent();
            $descriptionParent.text('').append($description).append(description);
        }

        $('select[name=product]').val(null).trigger("change");
        $('#product-modal').modal('hide');

      });

    $('.add-service').on('click', function() {
        clearServiceModal();
    });

    $('.add-product').on('click', function() {
        clearProductModal();
    });

    $('#service-modal').on('show.bs.modal', function(e) {
        let row = $(e.relatedTarget).data('row');
        if (row) {
            setFildsServiceModal(row);
            $('.btn-add-service').attr('data-row', row);
        }
    });

    $('#product-modal').on('show.bs.modal', function(e) {
        let row = $(e.relatedTarget).data('row');
        if (row) {
            setFildsProductModal(row);
            $('.btn-add-product').attr('data-row', row);
        }
    });

    $('#delete-modal').on('show.bs.modal', function(e) {
        let row = $(e.relatedTarget).data('row');
        $('.btn-delete').attr('data-row', row);
    });

    $('.btn-delete').on('click', function(e) {
        let row = $(this).attr('data-row');
        $('#' + row).remove();
        $('#delete-modal').modal('hide');
    });

    function ceckServiceValues() {
        let service = $('select[name=service]').select2('data')[0];
        let serviceType = $('select[name=service_type]').select2('data')[0];
        let executedAt = $('input[name=executed_at]').val();

        let $service = $('select[name=service]');
        let $serviceType = $('select[name=service_type]');
        let $executedAt = $('input[name=executed_at]');

        !service ? $service.addClass('is-invalid') : $service.removeClass('is-invalid');
        !serviceType ? $serviceType.addClass('is-invalid') : $serviceType.removeClass('is-invalid');
        (!executedAt || executedAt == '') ? $executedAt.addClass('is-invalid') : $executedAt.removeClass('is-invalid');

        return service && serviceType && executedAt;
    }

    function ceckProductValues() {
        let product = $('select[name=product]').select2('data')[0];

        let $product = $('select[name=product]');

        !product ? $product.addClass('is-invalid') : $product.removeClass('is-invalid');

        return product;
    }

    function setFildsServiceModal(row) {
        clearServiceModal();

        let $row = $('#' + row);
        let index = $row.attr('data-row');

        let serviceId = $("input[name='services[" + index + "][budget_service_id]']").val();
        let serviceName = $("input[name='services[" + index + "][service_name]']").val();

        let serviceTypeId = $("input[name='services[" + index + "][service_type_id]']").val();
        let serviceTypeName = $("input[name='services[" + index + "][service_type_name]']").val();

        let executedAt = $("input[name='services[" + index + "][executed_at]']").val();
        let equipmentId = $("input[name='services[" + index + "][equipment_id]']").val();
        let description = $("input[name='services[" + index + "][description]']").val();


        let $service = $('select[name=service]');
        let $serviceType = $('select[name=service_type]');
        let $executedAt = $('input[name=executed_at]');
        let $equipmentId = $('input[name=equipment_id]');
        let $description = $('textarea[name=product-description]');

        var serviceOption = new Option(serviceName, serviceId, false, false);
        var serviceTypeOption = new Option(serviceTypeName, serviceTypeId, false, false);

        $service.append(serviceOption).trigger('change');
        $serviceType.append(serviceTypeOption).trigger('change');
        $executedAt.val(executedAt);
        $equipmentId.val(equipmentId);
        $description.val(description);
    }

    function setFildsProductModal(row) {
        clearProductModal();

        let $row = $('#' + row);
        let index = $row.attr('data-row');

        let productId = $("input[name='products[" + index + "][budget_product_id]']").val();
        let productName = $("input[name='products[" + index + "][product_name]']").val();

        let description = $("input[name='products[" + index + "][description]']").val();


        let $product = $('select[name=product]');
        let $description = $('textarea[name=product-description]');

        var productOption = new Option(productName, productId, false, false);

        $product.append(productOption).trigger('change');
        $description.val(description);
      }

    function clearServiceModal() {
        $("select[name=service]").empty().trigger('change');
        $("select[name=service_type]").empty().trigger('change');
        $('input[name=executed_at]').val('');
        $('input[name=equipment_id]').val('');
        $('textarea[name=service-description]').val('');
    }

    function clearProductModal() {
        $("select[name=product]").empty().trigger('change');
        $('textarea[name=product-description]').val('');
      }

});
