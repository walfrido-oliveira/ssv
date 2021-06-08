/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 8);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/order.js":
/*!*******************************!*\
  !*** ./resources/js/order.js ***!
  \*******************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  $('select[name=client_id]').select2({
    language: "pt-BR",
    theme: 'bootstrap4',
    ajax: {
      url: '/admin/clients/find',
      dataType: 'json',
      data: function data(params) {
        var query = {
          q: $.trim(params.term),
          page: params.page
        };
        return query;
      },
      processResults: function processResults(data, params) {
        params.page = params.page || 1;
        return {
          results: data,
          pagination: {
            more: params.page * 30 < data.total_count
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
      data: function data(params) {
        var query = {
          q: $.trim(params.term),
          client_id: $("select[name='client_id'").val(),
          page: params.page
        };
        return query;
      },
      processResults: function processResults(data, params) {
        params.page = params.page || 1;
        return {
          results: data,
          pagination: {
            more: params.page * 30 < data.total_count
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
      data: function data(params) {
        var query = {
          q: $.trim(params.term),
          budget_id: $("select[name='budget_id'").val(),
          page: params.page
        };
        return query;
      },
      processResults: function processResults(data, params) {
        params.page = params.page || 1;
        return {
          results: data,
          pagination: {
            more: params.page * 30 < data.total_count
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
      data: function data(params) {
        var query = {
          q: $.trim(params.term),
          budget_id: $("select[name='budget_id'").val(),
          page: params.page
        };
        return query;
      },
      processResults: function processResults(data, params) {
        params.page = params.page || 1;
        return {
          results: data,
          pagination: {
            more: params.page * 30 < data.total_count
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
      data: function data(params) {
        var query = {
          q: $.trim(params.term),
          page: params.page
        };
        return query;
      },
      processResults: function processResults(data, params) {
        params.page = params.page || 1;
        return {
          results: data,
          pagination: {
            more: params.page * 30 < data.total_count
          }
        };
      },
      cache: true
    }
  });
  $("select[name='client_id'").on('change', function () {
    $("select[name=budget_id]").empty().trigger('change');
  });
  $('.btn-add-service').on('click', function () {
    if (!ceckServiceValues()) return;
    var dataRow = $(this).attr('data-row');
    var tbody = $('.table-service tbody');
    var service = $('select[name=service]').select2('data')[0];
    var serviceType = $('select[name=service_type]').select2('data')[0];
    var executedAt = $('input[name=executed_at]').val();
    var equipmentId = $('input[name=equipment_id]').val();
    var description = $('textarea[name=service-description]').val();
    var index = tbody.find('tr').length;

    if (!dataRow) {
      index++;
      var row = '<tr id="row-service-' + (index - 1) + '" data-row="' + (index - 1) + '">' + '<td>' + index + '<input type="hidden" name="services[' + (index - 1) + '][budget_service_id]" value="' + service.id + '" />' + '<input type="hidden" name="services[' + (index - 1) + '][service_type_id]" value="' + serviceType.id + '" />' + '<input type="hidden" name="services[' + (index - 1) + '][index]" value="' + (index - 1) + '" />' + '</td>' + '<td>' + service.name + '<input type="hidden" name="services[' + (index - 1) + '][service_name]" value="' + service.name + '" /></td>' + '<td>' + dateToDMY(executedAt) + '<input type="hidden" name="services[' + (index - 1) + '][executed_at]" value="' + executedAt + '" /></td>' + '<td>' + equipmentId + '<input type="hidden" name="services[' + (index - 1) + '][equipment_id]" value="' + equipmentId + '" /></td>' + '<td>' + serviceType.name + '<input type="hidden" name="services[' + (index - 1) + '][service_type_name]" value="' + serviceType.name + '" /></td>' + '<td>' + description + '<input type="hidden" name="services[' + (index - 1) + '][description]" value="' + description + '" /></td>' + '<td>' + CURRENT_USER + '</td>' + '<td width="15%">' + '<div class="btn-group">' + '<a href="#" class="btn-secondary btn-sm btn-edit-service" data-toggle="modal" data-target="#service-modal" data-row="row-service-' + (index - 1) + '">' + '<i class="fas fa-pencil-alt"></i>' + '</a>' + '</div>&nbsp;' + '<div class="btn-group">' + '<a href="#" class="btn btn-danger btn-sm btn-remove-service" data-toggle="modal" data-target="#delete-modal" data-row="row-service-' + (index - 1) + '">' + '<i class="fas fa-trash-alt"></i>' + '</a>' + '</div>' + '</td>' + '</tr>';
      tbody.append(row);
    } else {
      var $row = $('#' + dataRow);
      index = $row.index();
      var $serviceId = $("input[name='services[" + index + "][budget_service_id]']");
      var $serviceName = $("input[name='services[" + index + "][service_name]']");
      var $serviceTypeId = $("input[name='services[" + index + "][service_type_id]']");
      var $serviceTypeName = $("input[name='services[" + index + "][service_type_name]']");
      var $executedAt = $("input[name='services[" + index + "][executed_at]']");
      var $equipmentId = $("input[name='services[" + index + "][equipment_id]']");
      var $description = $("input[name='services[" + index + "][description]']");
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
  $('.btn-add-product').on('click', function () {
    if (!ceckProductValues()) return;
    var dataRow = $(this).attr('data-row');
    var tbody = $('.table-product tbody');
    var product = $('select[name=product]').select2('data')[0];
    var description = $('textarea[name=product-description]').val();
    var index = tbody.find('tr').length;

    if (!dataRow) {
      index++;
      var row = '<tr id="row-product-' + (index - 1) + '" data-row="' + (index - 1) + '">' + '<td>' + index + '<input type="hidden" name="products[' + (index - 1) + '][budget_product_id]" value="' + product.id + '" />' + '<input type="hidden" name="products[' + (index - 1) + '][index]" value="' + (index - 1) + '" />' + '</td>' + '<td>' + product.name + '<input type="hidden" name="products[' + (index - 1) + '][product_name]" value="' + product.name + '" /></td>' + '<td>' + description + '<input type="hidden" name="products[' + (index - 1) + '][description]" value="' + description + '" /></td>' + '<td>' + CURRENT_USER + '</td>' + '<td width="15%">' + '<div class="btn-group">' + '<a href="#" class="btn-secondary btn-sm btn-edit-product" data-toggle="modal" data-target="#product-modal" data-row="row-product-' + (index - 1) + '">' + '<i class="fas fa-pencil-alt"></i>' + '</a>' + '</div>&nbsp;' + '<div class="btn-group">' + '<a href="#" class="btn btn-danger btn-sm btn-remove-product" data-toggle="modal" data-target="#delete-modal" data-row="row-product-' + (index - 1) + '">' + '<i class="fas fa-trash-alt"></i>' + '</a>' + '</div>' + '</td>' + '</tr>';
      tbody.append(row);
    } else {
      var $row = $('#' + dataRow);
      index = $row.index();
      var $productId = $("input[name='products[" + index + "][budget_product_id]']");
      var $productName = $("input[name='products[" + index + "][product_name]']");
      var $description = $("input[name='products[" + index + "][description]']");
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
  $('.add-service').on('click', function () {
    clearServiceModal();
  });
  $('.add-product').on('click', function () {
    clearProductModal();
  });
  $('#service-modal').on('show.bs.modal', function (e) {
    var row = $(e.relatedTarget).data('row');

    if (row) {
      setFildsServiceModal(row);
      $('.btn-add-service').attr('data-row', row);
    }
  });
  $('#product-modal').on('show.bs.modal', function (e) {
    var row = $(e.relatedTarget).data('row');

    if (row) {
      setFildsProductModal(row);
      $('.btn-add-product').attr('data-row', row);
    }
  });
  $('#delete-modal').on('show.bs.modal', function (e) {
    var row = $(e.relatedTarget).data('row');
    $('.btn-delete').attr('data-row', row);
  });
  $('.btn-delete').on('click', function (e) {
    var row = $(this).attr('data-row');
    $('#' + row).remove();
    $('#delete-modal').modal('hide');
  });

  function ceckServiceValues() {
    var service = $('select[name=service]').select2('data')[0];
    var serviceType = $('select[name=service_type]').select2('data')[0];
    var executedAt = $('input[name=executed_at]').val();
    var $service = $('select[name=service]');
    var $serviceType = $('select[name=service_type]');
    var $executedAt = $('input[name=executed_at]');
    !service ? $service.addClass('is-invalid') : $service.removeClass('is-invalid');
    !serviceType ? $serviceType.addClass('is-invalid') : $serviceType.removeClass('is-invalid');
    !executedAt || executedAt == '' ? $executedAt.addClass('is-invalid') : $executedAt.removeClass('is-invalid');
    return service && serviceType && executedAt;
  }

  function ceckProductValues() {
    var product = $('select[name=product]').select2('data')[0];
    var $product = $('select[name=product]');
    !product ? $product.addClass('is-invalid') : $product.removeClass('is-invalid');
    return product;
  }

  function setFildsServiceModal(row) {
    clearServiceModal();
    var $row = $('#' + row);
    var index = $row.attr('data-row');
    var serviceId = $("input[name='services[" + index + "][budget_service_id]']").val();
    var serviceName = $("input[name='services[" + index + "][service_name]']").val();
    var serviceTypeId = $("input[name='services[" + index + "][service_type_id]']").val();
    var serviceTypeName = $("input[name='services[" + index + "][service_type_name]']").val();
    var executedAt = $("input[name='services[" + index + "][executed_at]']").val();
    var equipmentId = $("input[name='services[" + index + "][equipment_id]']").val();
    var description = $("input[name='services[" + index + "][description]']").val();
    var $service = $('select[name=service]');
    var $serviceType = $('select[name=service_type]');
    var $executedAt = $('input[name=executed_at]');
    var $equipmentId = $('input[name=equipment_id]');
    var $description = $('textarea[name=product-description]');
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
    var $row = $('#' + row);
    var index = $row.attr('data-row');
    var productId = $("input[name='products[" + index + "][budget_product_id]']").val();
    var productName = $("input[name='products[" + index + "][product_name]']").val();
    var description = $("input[name='products[" + index + "][description]']").val();
    var $product = $('select[name=product]');
    var $description = $('textarea[name=product-description]');
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

/***/ }),

/***/ 8:
/*!*************************************!*\
  !*** multi ./resources/js/order.js ***!
  \*************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\xampp\htdocs\ssv\resources\js\order.js */"./resources/js/order.js");


/***/ })

/******/ });