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
/******/ 	return __webpack_require__(__webpack_require__.s = 5);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/budget.js":
/*!********************************!*\
  !*** ./resources/js/budget.js ***!
  \********************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  $('select[name=client_id]').select2({
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
  $('select[name=client_id]').on('change', function (e) {
    $('select[name=client_contact_id]').val(null).trigger('change');
  });
  $('select[name=client_contact_id]').select2({
    ajax: {
      url: '/admin/contacts/find',
      dataType: 'json',
      data: function data(params) {
        var query = {
          q: $.trim(params.term),
          client_id: $('select[name=client_id').find(':selected').val(),
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
    },
    templateResult: formatContact,
    templateSelection: formatContactSelection
  });
  $('select[name=service]').select2({
    ajax: {
      url: '/admin/services/find',
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
  $('select[name=product]').select2({
    ajax: {
      url: '/admin/products/find',
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
  $('.btn-add-service').on('click', function (e) {
    var tbody = $('.table-service tbody');
    var service = $('select[name=service]').find(':selected');
    var amount = $('input[name=service_amount]');
    var index = tbody.find('tr').length + 1;
    var row = '<tr id="row-service-' + (index - 1) + '">' + '<td>' + index + '<input type="hidden" name="services[' + (index - 1) + '][service_id]" value="' + service.val() + '" /></td>' + '<td>' + service.text() + '<input type="hidden" name="services[' + (index - 1) + '][service_name]" value="' + service.text() + '" /></td>' + '<td>' + amount.val() + '<input type="hidden" name="services[' + (index - 1) + '][amount]" value="' + amount.val() + '" /></td>' + '<td width="15%">' + '<a href="#" class="btn btn-danger btn-sm btn-remove-service" data-toggle="modal" data-target="#delete-modal" data-row="row-service-' + (index - 1) + '">' + '<i class="fas fa-trash-alt"></i>' + '</a>' + '</tr>';
    tbody.append(row);
    $('select[name=service]').val(null).trigger("change");
    amount.val(1);
    $('#service-modal').modal('hide');
  });
  $('.btn-add-product').on('click', function (e) {
    var tbody = $('.table-product tbody');
    var product = $('select[name=product]').find(':selected');
    var amount = $('input[name=product_amount]');
    var index = tbody.find('tr').length + 1;
    var row = '<tr id="row-product-' + (index - 1) + '">' + '<td>' + index + '<input type="hidden" name="products[' + (index - 1) + '][product_id]" value="' + product.val() + '" /></td>' + '<td>' + product.text() + '<input type="hidden" name="products[' + (index - 1) + '][product_name]" value="' + product.text() + '" /></td>' + '<td>' + amount.val() + '<input type="hidden" name="products[' + (index - 1) + '][amount]" value="' + amount.val() + '" /></td>' + '<td width="15%">' + '<a href="#" class="btn btn-danger btn-sm btn-remove-product" data-toggle="modal" data-target="#delete-modal" data-row="row-product-' + (index - 1) + '">' + '<i class="fas fa-trash-alt"></i>' + '</a>' + '</tr>';
    tbody.append(row);
    $('select[name=product]').val(null).trigger("change");
    amount.val(1);
    $('#product-modal').modal('hide');
  });
  $('.btn-cancel').on('click', function (e) {
    $('select[name=service]').val(null).trigger("change");
    $('input[name=service_amount]').val(1);
    $('select[name=product]').val(null).trigger("change");
    $('input[name=product_amount]').val(1);
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
});

function formatContact(contact) {
  if (contact.loading) {
    return contact.text;
  }

  var $container = $("<div class='select2-result-contact clearfix'>" + "<div class='select2-result-contact__meta'>" + "<div class='select2-result-contact__contact'></div>" + "<div class='select2-result-contact__department'></div>" + "<div class='select2-result-contact__phone'></div>" + "<div class='select2-result-contact__mobile_phone'></div>" + "<div class='select2-result-contact__email'></div>" + "</div>" + "</div>");
  $container.find(".select2-result-contact__contact").text(contact.contact);
  $container.find(".select2-result-contact__department").text(contact.department);
  $container.find(".select2-result-contact__phone").text(contact.phone);
  $container.find(".select2-result-contact__mobile_phone").text(contact.mobile_phone);
  $container.find(".select2-result-contact__email").text(contact.email);
  return $container;
}

function formatContactSelection(contact) {
  var name = contact.contact;
  var email = contact.email;
  if (!name) name = '';
  if (!email) email = '';
  return name != '' || email != '' ? name + ' - ' + email : contact.text;
}

/***/ }),

/***/ 5:
/*!**************************************!*\
  !*** multi ./resources/js/budget.js ***!
  \**************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\xampp\htdocs\ssv\resources\js\budget.js */"./resources/js/budget.js");


/***/ })

/******/ });