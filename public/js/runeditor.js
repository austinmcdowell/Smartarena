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

  var currentVideo = {};
  var playbackInterval = null;
  var isIntervalSet = false;

  var onLoad = true;

  // hammer event functions

  var zoomIn = function zoomIn() {
    if (CURRENT_SCALE < 1) {
      return;
    }
    CURRENT_SCALE += 0.1;
    isZoomed = true;
    $('#my-video_html5_api').css({ transform: 'scale(' + CURRENT_SCALE + ')' });
  };

  var zoomOut = function zoomOut() {
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
  };

  var pan = function pan(ev) {
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
  };

  // video functions

  var play = function play(file) {
    $('#video-player').show();
    var reader = new FileReader();
    reader.onload = function (videoFile) {
      var player = videojs('my-video');
      player.src({ type: 'video/mp4', src: videoFile.target.result });
    };
    reader.readAsDataURL(file);
  };

  var rewind = function rewind(rate, ms) {
    if (!isIntervalSet) {
      var player = videojs('my-video');
      player.pause();
      player.currentTime(player.currentTime() - rate);
      playbackInterval = setInterval(function () {
        player.currentTime(player.currentTime() - rate);
      }, ms);
      isIntervalSet = true;
    }
  };

  var forward = function forward(rate, ms) {
    if (!isIntervalSet) {
      var player = videojs('my-video');
      player.pause();
      player.currentTime(player.currentTime() + rate);
      playbackInterval = setInterval(function () {
        player.currentTime(player.currentTime() + rate);
      }, ms);
      isIntervalSet = true;
    }
  };

  var resetScrobbling = function resetScrobbling() {
    clearInterval(playbackInterval);
    isIntervalSet = false;
  };

  // Catch functions

  var setCatchType = function setCatchType(element, riderType) {
    var isCatch = element.hasClass('catch') ? true : false;
    var catchType = element.data('catch-type');
    var card = $(element.parents('.card')[0]);

    card.find('.catch-type-button').each(function (index, el) {
      var button = $(el);
      button.css({
        'background-color': '#fff',
        'color': '#000'
      });
    });

    if (isCatch) {
      if (SA.run[riderType].catchType === catchType && !onLoad) {
        SA.run[riderType].catchType = null;
        return;
      }
      SA.run[riderType].catchType = catchType;
      if (SA.run.header.penaltyType) {
        $('.heeler-stats').find('.catch-type-button').each(function (index, el) {
          var button = $(el);
          button.css({
            'background-color': '#fff',
            'color': '#000'
          });
        });
        SA.run.header.penaltyType = null;
      }
      element.css({
        'background-color': '#28a745',
        'color': '#fff'
      });
    } else {
      if (SA.run[riderType].penaltyType === catchType && !onLoad) {
        SA.run[riderType].penaltyType = null;
        return;
      }

      // disable heeler stats and clear is header missed
      if (riderType === 'header' && catchType === 'missed') {
        $('.heeler-stats').find('.catch-type-button').each(function (index, el) {
          var button = $(el);
          button.css({
            'background-color': '#ccc',
            'color': '#fff'
          });
        });
        SA.run.heeler.catchType = null;
        SA.run.heeler.penaltyType = null;
      }

      SA.run[riderType].penaltyType = catchType;
      SA.run[riderType].catchType = null;
      element.css({
        'background-color': 'red',
        'color': '#fff'
      });
    }
  };

  // Set Field Values on Load (for Edits)

  var setFieldValues = function setFieldValues() {
    $('#date').val(SA.run.date);
    $('#event-select').val(SA.run.eventId);
    $('#roping').val(SA.run.roping);
    $('#round').val(SA.run.round);
    $('#time').val(SA.run.time);

    $('#no-time').prop('checked', SA.run.noTime);
    $('#score').prop('checked', SA.run.score);

    $('#header-select').val(SA.run.header.humanId);
    $('#header-barrier-penalty').val(SA.run.header.barrierPenalty);

    $('#heeler-select').val(SA.run.heeler.humanId);
    $('#heeler-barrier-penalty').val(SA.run.heeler.barrierPenalty);

    if (SA.run.header.catchType) {
      console.log(SA.run.header.catchType);
      var element = $($('.header-stats').find('[data-catch-type=\'' + SA.run.header.catchType + '\']')[0]);
      setCatchType(element, 'header');
    } else if (SA.run.header.penaltyType) {
      var _element = $($('.header-stats').find('[data-catch-type=\'' + SA.run.header.penaltyType + '\']')[0]);
      setCatchType(_element, 'header');
    }

    if (SA.run.heeler.catchType) {
      var _element2 = $($('.heeler-stats').find('[data-catch-type=\'' + SA.run.heeler.catchType + '\']')[0]);
      setCatchType(_element2, 'heeler');
    } else if (SA.run.heeler.penaltyType) {
      var _element3 = $($('.heeler-stats').find('[data-catch-type=\'' + SA.run.heeler.penaltyType + '\']')[0]);
      setCatchType(_element3, 'heeler');
    }

    onLoad = false;
  };

  // hammer initialization
  var el = document.getElementById('protection');
  var hammertime = new Hammer.Manager(el);
  var panGesture = new Hammer.Pan();
  hammertime.add([panGesture]);

  hammertime.on('pan', function (ev) {
    pan(ev);
  });

  hammertime.on('panend', function (ev) {
    LAST_DELTA_Y = 0;
    LAST_DELTA_X = 0;
  });

  $('.zoom-in').on('click tap', function (e) {
    zoomIn();
  });

  $('.zoom-out').on('click tap', function (e) {
    zoomOut();
  });

  // disable drag and drop on the window

  $(window).on('drop', function (e) {
    e.preventDefault();
    e.stopPropagation();
  });

  $(window).on('dragover', function (e) {
    e.preventDefault();
    e.stopPropagation();
  });

  // video controls

  $('.double-rewind').on('mousedown touchstart', function (e) {
    e.preventDefault();
    rewind(0.2, 125);
  });

  $('.single-rewind').on('mousedown touchstart', function (e) {
    e.preventDefault();
    rewind(0.1, 125);
  });

  $('.single-forward').on('mousedown touchstart', function (e) {
    e.preventDefault();
    forward(0.1, 125);
  });

  $('.double-forward').on('mousedown touchstart', function (e) {
    e.preventDefault();
    forward(0.2, 125);
  });

  $('.control-button').on('mouseup touchend', function (e) {
    e.preventDefault();
    resetScrobbling();
  });

  $('.upload-card').on('drop', function (e) {
    var file = e.originalEvent.dataTransfer.files[0];
    var form = new FormData();
    form.append('video', file);

    if (file.type !== 'video/mp4') {
      alert('The only file type we currently accept is MP4.');
      return;
    }

    play(file);

    $.ajax({
      type: 'POST',
      processData: false,
      contentType: false,
      data: form,
      url: '/teamroping/upload',
      beforeSend: function beforeSend(request, xhr) {
        $('.upload-progress').show();
        $('.upload-progress .determinate').css('width', '0%');
        $('.save-button').addClass('disabled');
      },
      xhr: function xhr() {
        var xhr = $.ajaxSettings.xhr();

        xhr.upload.onprogress = function (data) {
          var perc = Math.round(data.loaded / data.total * 100);
          $('.upload-progress .determinate').css('width', perc + '%');
        };

        return xhr;
      },
      success: function success(data) {
        currentVideo = data;
        currentVideo.newUpload = true;
        $('.save-button').removeClass('disabled');
      }
    });
  });

  $('.header-stats .catch').on('click', function (e) {
    e.preventDefault();
    var element = $(this);
    setCatchType(element, 'header');
  });

  $('.header-stats .penalty').on('click', function (e) {
    e.preventDefault();
    var element = $(this);
    setCatchType(element, 'header');
  });

  $('.heeler-stats .catch').on('click', function (e) {
    e.preventDefault();
    var element = $(this);
    if (SA.run.header.penaltyType !== 'missed') {
      setCatchType(element, 'heeler');
    }
  });

  $('.heeler-stats .penalty').on('click', function (e) {
    e.preventDefault();
    var element = $(this);
    if (SA.run.header.penaltyType !== 'missed') {
      setCatchType(element, 'heeler');
    }
  });

  // Save Button
  $('.save-button').on('click', function (e) {
    e.preventDefault();

    SA.run.date = $('#date').val();
    SA.run.eventId = $('#event-select').val();
    SA.run.roping = $('#roping').val();
    SA.run.round = $('#round').val();
    SA.run.time = $('#time').val();

    if ($('#no-time').val() === "on") {
      SA.run.noTime = true;
    } else {
      SA.run.noTime = false;
    }

    if ($('#score').val() === "on") {
      SA.run.score = true;
    } else {
      SA.run.score = false;
    }

    SA.run.header.humanId = $('#header-select').val();
    SA.run.header.barrierPenalty = $('header-barrier-penalty').val();
    SA.run.heeler.humanId = $('#heeler-select').val();
    SA.run.heeler.barrierPenalty = $('heeler-barrier-penalty').val();
    SA.run.currentVideo = currentVideo;

    if (SA.run.header.humanId === SA.run.heeler.humanId) {
      alert('The header and heeler cannot both be the same person!');
      return;
    }

    if (!SA.run.eventId) {
      alert('You must select an event!');
      return;
    }

    if (!SA.run.header.humanId || !SA.run.heeler.humanId) {
      alert('You must select both a header and heeler.');
      return;
    }

    $.ajax({
      type: 'POST',
      contentType: 'application/json',
      data: JSON.stringify(SA.run),
      url: '/teamroping/save',
      success: function success(data) {
        window.location.replace('/profile/' + SA.humanId);
      },
      error: function error(xhr, textStatus, _error) {
        console.log(xhr, textStatus, _error);
        alert("Something went wrong. Please contact support.");
        //window.history.back();
      }
    });
  });

  // init:

  // A video exists on load
  // let's show the video player and hide the uploader.
  if (SA.videos.length) {
    $('#video-player').show();
    var player = videojs('my-video');
    var video = SA.videos[0];
    player.src({ type: 'video/mp4', src: video.file_url });
    player.play();
  }

  // Create SA.run object
  SA.run = {
    header: {},
    heeler: {}
  };

  if (SA.rawRun) {
    SA.run.runId = SA.rawRun.id;
    SA.run.eventId = SA.rawRun.event_id;
    SA.run.date = SA.rawRun.date;

    SA.run.header.barrierPenalty = SA.rawRun.header_barrier_penalty;
    SA.run.header.catchType = SA.rawRun.header_catch_type;
    SA.run.header.humanId = SA.rawRun.header_human_id;
    SA.run.header.penaltyType = SA.rawRun.header_penalty_type;

    SA.run.heeler.barrierPenalty = SA.rawRun.heeler_barrier_penalty;
    SA.run.heeler.catchType = SA.rawRun.heeler_catch_type;
    SA.run.heeler.humanId = SA.rawRun.heeler_human_id;
    SA.run.heeler.penaltyType = SA.rawRun.heeler_penalty_type;

    SA.run.time = SA.rawRun.raw_time;
    SA.run.roping = SA.rawRun.roping;
    SA.run.round = SA.rawRun.round;

    setFieldValues();
  }

  // Date picker initializer
  $('#date').pickadate({
    selectMonths: true, // Creates a dropdown to control month
    selectYears: 15, // Creates a dropdown of 15 years to control year,
    today: 'Today',
    clear: 'Clear',
    close: 'Ok',
    closeOnSelect: true // Close upon selecting a date,
  });
});

/***/ })

/******/ });