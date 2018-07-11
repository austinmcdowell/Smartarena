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
/******/ 	return __webpack_require__(__webpack_require__.s = 87);
/******/ })
/************************************************************************/
/******/ ({

/***/ 87:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(88);


/***/ }),

/***/ 88:
/***/ (function(module, exports) {

$(document).ready(function () {
  var classificationInput = $('#classification');
  var firstNameInput = $('#first_name');
  var lastNameInput = $('#last_name');
  var emailInput = $('#email');
  var phoneInput = $('#phone');
  var locationInput = $('#location');

  $('.upload-button').on('click', function (e) {
    e.preventDefault();
    var classification = parseInt(classificationInput.val());
    var firstName = firstNameInput.val();
    var lastName = lastNameInput.val();
    var email = emailInput.val();
    var phone = phoneInput.val();
    var location = locationInput.val();

    var payload = {
      classification: classification,
      firstName: firstName,
      lastName: lastName,
      email: email,
      phone: phone,
      location: location
    };

    var validationErrors = validate(payload, {
      email: {
        email: true
      }
    });

    if (validationErrors) {
      var error = "";

      for (var i = 0; i < validationErrors['email'].length; i++) {
        error += validationErrors['email'][i] + '\n';
      }

      alert(error);
      return;
    }

    $.post('/createhuman', payload, function (data) {
      if (data.success) {
        alert("Human successfully created.");
      } else {
        alert(data.message);
      }
    });
  });
});

/***/ })

/******/ });