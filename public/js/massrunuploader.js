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
/******/ 	return __webpack_require__(__webpack_require__.s = 53);
/******/ })
/************************************************************************/
/******/ ({

/***/ 53:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(54);


/***/ }),

/***/ 54:
/***/ (function(module, exports) {

$(document).ready(function () {
  var queue = [];

  var parseDate = function parseDate(string) {
    var newDate = new Date(string);
    if (newDate.toJSON === null) {
      return new Date(0);
    } else {
      return newDate;
    }
  };

  var parseBool = function parseBool(string) {
    return string.toString().trim().toLowerCase() === 'true';
  };

  var parseRun = function parseRun(run, eventId) {
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
  };

  var parseContentsOf = function parseContentsOf(entry) {
    if (entry.isFile) {
      if (entry.name !== '.DS_Store') {
        return prepareForUpload(entry);
      }
    } else {
      var entryReader = entry.createReader();
      var promises = [];
      return new Promise(function (resolve, reject) {
        promises.push(new Promise(function (resolveEntry, rejectEntry) {
          entryReader.readEntries(function (entryNodes) {
            var childPromises = [];
            entryNodes.forEach(function (node) {
              if (node.name !== '.DS_Store') {
                if (node.isDirectory) {
                  childPromises.push(parseContentsOf(node));
                } else {
                  childPromises.push(prepareForUpload(node));
                }
              }
            });
            resolveEntry(Promise.all(childPromises));
          });
        }));
        resolve(Promise.all(promises));
      });
    }
  };

  var prepareForUpload = function prepareForUpload(fileEntry) {
    return new Promise(function (resolve, reject) {
      fileEntry.file(function (file) {
        var filename = fileEntry.name;

        queue.push(function () {
          var form = new FormData();
          form.append('video', file);

          if (file.type !== 'video/mp4') {
            alert('The only file type we currently accept is MP4.');
            return Promise.reject();
          }

          return $.ajax({
            type: 'POST',
            processData: false,
            contentType: false,
            data: form,
            url: '/massupload/runs/uploadVideo',
            beforeSend: function beforeSend(request, xhr) {
              $('.upload-progress .determinate').css('width', '0%');
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
              $('<li>' + filename + ' was uploaded successfully!</li>').appendTo('#successfully-uploaded');
            }
          });
        });
        resolve();
      });
    });
  };

  // disable drag and drop on the window

  $(window).on('drop', function (e) {
    e.preventDefault();
    e.stopPropagation();
  });

  $(window).on('dragover', function (e) {
    e.preventDefault();
    e.stopPropagation();
  });

  $('.upload-card').on('drop', function (e) {
    var length = e.originalEvent.dataTransfer.items.length;
    var parentPromises = [];

    for (var i = 0; i < length; i++) {
      var entry = e.originalEvent.dataTransfer.items[i].webkitGetAsEntry();
      parentPromises.push(parseContentsOf(entry));
    }

    Promise.all(parentPromises).then(function () {
      if (queue.length === 1) {
        return queue[0]();
      } else {
        queue.reduce(function (promiseChain, nextPromise) {
          // All of the items in the queue are functions, but the only way this can run is if we run .then against a promise
          // We first check if promiseChain is a function and if so we call it. After that iteration it'll be a promise object.
          if (typeof promiseChain === 'function') {
            return promiseChain().then(function (result) {
              return nextPromise().then(Array.prototype.concat.bind(result));
            }, Promise.resolve([]));
          } else {
            return promiseChain.then(function (result) {
              return nextPromise().then(Array.prototype.concat.bind(result));
            }, Promise.resolve([]));
          }
        });
      }
    });
  });

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
        alert('Runs imported successfully!');
      } else {
        alert('There was an error.');
      }
    });
  });
});

/***/ })

/******/ });