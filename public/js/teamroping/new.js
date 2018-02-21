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
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
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
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 43);
/******/ })
/************************************************************************/
/******/ ({

/***/ 43:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(44);


/***/ }),

/***/ 44:
/***/ (function(module, exports) {

$(document).ready(function () {
  var STEPPER_SELECTOR_HEIGHT = 84;
  var stepperContent = $('.step-content');
  var stepper = $('.stepper');
  var form = $('#runForm');
  var nextButton = $('.next-step-button');
  var isSaving = false;

  // Form elements
  var dateField = $('#date');
  var eventSelect = $('#event-select');
  var ropingField = $('#roping');
  var roundField = $('#round');
  var timeField = $('#time');
  var headerSelect = $('#header-select');
  var headerCatchCheckbox = $('header_did_catch');
  var heelerSelect = $('#heeler-select');
  var heelerCatchCheckbox = $('heeler_did_catch');

  function resizeStepper() {
    var stepperSize = stepperContent.prop('scrollHeight') + STEPPER_SELECTOR_HEIGHT;
    stepper.css('height', stepperSize);
  }

  stepper.activateStepper();
  resizeStepper();

  stepper.on('stepchange', function () {
    resizeStepper();
  });

  dateField.pickadate({
    selectMonths: true,
    selectYears: 15,
    today: 'Today',
    clear: 'Clear',
    close: 'Ok',
    closeOnSelect: true
  });

  form.validate({
    rules: {
      'date': {
        date: true
      },
      'event-select': {
        required: true
      },
      'time': {
        required: true
      },
      'header-select': {
        required: true
      },
      'heeler-select': {
        required: true
      }
    },
    errorPlacement: function errorPlacement(error, element) {
      var errorText = error[0].innerText;
      var siblingLabel = $(element.siblings('label')[0]);
      siblingLabel.text(errorText);
      siblingLabel.css('color', '#ee6e73');
    }
  });

  nextButton.on('click', function (e) {
    e.preventDefault();
    if (isSaving) {
      return;
    }
    isSaving = true;

    if (form.valid()) {
      nextButton.text('Saving...');
      nextButton.css('background-color', '#ee6e73');

      var payload = {};
      payload.date = dateField.val();
      payload.eventId = eventSelect.val();
      payload.roping = ropingField.val();
      payload.round = roundField.val();
      payload.time = timeField.val();
      payload.headerId = headerSelect.val();
      payload.headerDidCatch = headerCatchCheckbox.val();
      payload.heelerId = heelerSelect.val();
      payload.heelerDidPatch = heelerCatchCheckbox.val();

      $.post('/teamroping', payload, function (data) {
        stepper.nextStep();
      }).fail(function () {
        alert('Something went wrong. Please try again later.');
      }).always(function () {
        nextButton.text('Continue');
        nextButton.css('background-color', '#26a69a');
        isSaving = false;
      });
    } else {
      console.log('abort!');
      isSaving = false;
    }
  });
});

/***/ })

/******/ });