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
/******/ 	return __webpack_require__(__webpack_require__.s = 45);
/******/ })
/************************************************************************/
/******/ ({

/***/ 45:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(46);


/***/ }),

/***/ 46:
/***/ (function(module, exports) {

$(document).ready(function () {

  var videoHeight = $('#my-video').height();
  var videoWidth = $('#my-video').width();

  var LAST_DELTA_X = 0;
  var LAST_DELTA_Y = 0;

  var CURRENT_SCALE = 1;

  var isZoomed = false;
  var el = document.getElementById('protection');

  var hammertime = new Hammer.Manager(el);
  var pan = new Hammer.Pan();

  hammertime.add([pan]);

  hammertime.on('pan', function (ev) {
    if (ev.srcEvent.srcElement.className.split(' ').indexOf('vjs-control') !== -1) {
      console.log(ev.srcEvent.srcElement.className);
      return;
    }

    var currentTop = parseInt($('#my-video_html5_api').css('top'), 10);
    var currentLeft = parseInt($('#my-video_html5_api').css('left'), 10);

    var top = currentTop + (ev.deltaY - LAST_DELTA_Y);
    var left = currentLeft + (ev.deltaX - LAST_DELTA_X);

    LAST_DELTA_Y = ev.deltaY;
    LAST_DELTA_X = ev.deltaX;

    var currentWidth = $('#my-video_html5_api').width() * CURRENT_SCALE;
    var currentHeight = $('#my-video_html5_api').height() * CURRENT_SCALE;

    if (isZoomed) {
      if (left <= currentWidth / 5.6 && left >= -(currentWidth / 5.6)) {
        $('#my-video_html5_api').css({ left: left });
      }

      if (top <= currentHeight / 5.6 && top >= -(currentHeight / 5.6)) {
        $('#my-video_html5_api').css({ top: top });
      }
    }
  });

  hammertime.on('panend', function (ev) {
    LAST_DELTA_Y = 0;
    LAST_DELTA_X = 0;
  });

  $('.zoom-in').on('click tap', function (e) {
    e.preventDefault();

    if (CURRENT_SCALE < 1) {
      return;
    }

    CURRENT_SCALE += 0.1;

    isZoomed = true;
    $('#my-video_html5_api').css({ transform: 'scale(' + CURRENT_SCALE + ')' });
  });

  $('.zoom-out').on('click tap', function (e) {
    e.preventDefault();

    if (CURRENT_SCALE === 1) {
      return;
    }

    CURRENT_SCALE -= 0.1;

    if (CURRENT_SCALE > 1) {
      $('#my-video_html5_api').css({ transform: 'scale(' + CURRENT_SCALE + ')' });
    } else {
      isZoomed = false;
      $('#my-video_html5_api').css({ top: "0", left: "0" });
    }
  });
});

/***/ })

/******/ });