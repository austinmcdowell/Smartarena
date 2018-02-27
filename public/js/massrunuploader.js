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
/******/ 	return __webpack_require__(__webpack_require__.s = 41);
/******/ })
/************************************************************************/
/******/ ({

/***/ 41:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(42);


/***/ }),

/***/ 42:
/***/ (function(module, exports) {

$(document).ready(function () {
  // $('#event-select').material_select();

  function parseDate(string) {
    var newDate = new Date(string);
    if (newDate.toJSON === null) {
      return new Date(0);
    } else {
      return newDate;
    }
  }

  function parseBool(string) {
    return string.toString().trim().toLowerCase() === 'true';
  }

  function parseRun(run, eventId) {
    return {
      file: run[0].trim(),
      date: parseDate(run[1]),
      eventId: eventId,
      roping: run[2].trim(),
      round: run[3].trim(),
      rawTime: parseFloat(run[4]),
      headerSaid: run[5].trim(),
      headerName: run[6].trim().toLowerCase(),
      headerLocation: run[7].trim().toLowerCase(),
      heelerSaid: run[8].trim(),
      heelerName: run[9].trim().toLowerCase(),
      heelerLocation: run[10].trim().toLowerCase(),
      headerCatch: parseBool(run[11]),
      headerCatchType: run[12].trim(),
      headerPenaltyType: run[13].trim(),
      headerPenaltyTime: parseFloat(run[14]),
      heelerCatch: parseBool(run[15]),
      heelerCatchType: run[16].trim(),
      heelerPenaltyType: run[17].trim(),
      heelerPenaltyTime: parseFloat(run[18])
    };
  }

  $('.upload-button').on('click', function (e) {
    e.preventDefault();
    var csvData = $('.csv-textarea').val().split('\n');
    var eventId = $('#event-select').val();

    if (!eventId) {
      alert("You must select an event.");
      return;
    }

    var parsedCSVData = [];

    for (var i = 1; i < csvData.length; i++) {
      var run = csvData[i].split(',');
      if (run.length !== 19) {
        alert('Invalid data. Records do not contain enough data.');
        break;
      }
      parsedCSVData.push(parseRun(run, eventId));
    }

    console.log(parsedCSVData);

    $.post('/massupload/runs/process', JSON.stringify(parsedCSVData), function (data) {
      if (data.success) {
        alert('Humans imported successfully!');
      } else {
        alert('There was an error.');
      }
    });
  });
});

/***/ })

/******/ });