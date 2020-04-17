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
/******/ 	return __webpack_require__(__webpack_require__.s = 2);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/client.js":
/*!********************************!*\
  !*** ./resources/js/client.js ***!
  \********************************/
/*! no static exports found */
/***/ (function(module, exports) {

var currentContact = null;
$(document).on('click', ".btn-add", function (e) {
  e.preventDefault();
  var controlContact = $('.contact:first'),
      currentEntry = $(this).parents('.entry:first'),
      newEntry = $(currentEntry.clone()).appendTo('.contact:first');
  newEntry.find('input').val('');
  var selector = newEntry.find('input').attr('name');
  var index_value = selector.match(/\d+/)[0];
  var nextIndexValue = parseInt(index_value, 10) + 1;
  newEntry.find('input,select').each(function () {
    this.name = this.name.replace(selector.match(/\d+/)[0], nextIndexValue);
  });
  controlContact.find('.entry:not(:last) .btn-remove').removeAttr('disabled');
  controlContact.find('.entry:not(:last) .btn-add').attr('disabled', 'disabled');
  newEntry.find('.btn-remove').removeAttr('disabled');
  newEntry.find('.btn-add').removeAttr('disabled');
}).on('click', '.btn-remove', function (e) {
  window.currentContact = $(this).parents('.entry:first');
  $('#delete-modal').modal('show');
  e.preventDefault();
});
$('#delete-modal').on('show.bs.modal', function (e) {
  var id = $(e.relatedTarget).data('id');
  var url = $(e.relatedTarget).data('url');
  $('#btn-modal-delete-yes').attr('data-id', id).attr('data-url', url);
});
$(document).on('click', "#btn-modal-delete-yes", function (e) {
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
    success: function success(response) {
      toastr.success(response.message);
      var parents = $('.contact:first').find('.entry');

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
      }, 500); //scrollTop(scrollTo.offset().top);
    }
  });
});

/***/ }),

/***/ 2:
/*!**************************************!*\
  !*** multi ./resources/js/client.js ***!
  \**************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\xampp\htdocs\ssv\resources\js\client.js */"./resources/js/client.js");


/***/ })

/******/ });