$(document).ready(function() {
  let videoHeight = $('#my-video').height();
  let videoWidth  = $('#my-video').width();
  
  let LAST_DELTA_X = 0;
  let LAST_DELTA_Y = 0;
  let CURRENT_SCALE = 1;
  let isZoomed = false;

  let currentVideo = {};
  let playbackInterval = null;
  let isIntervalSet = false;

  // hammer event functions

  let zoomIn = function zoomIn() {
    if (CURRENT_SCALE < 1) {
      return;
    }
    CURRENT_SCALE += 0.1;
    isZoomed = true;
    $('#my-video_html5_api').css({ transform: 'scale(' + CURRENT_SCALE + ')' });
  }

  let zoomOut = function zoomOut() {
    if (CURRENT_SCALE === 1) {
      return;
    }

    CURRENT_SCALE -= 0.1;
  
    if (CURRENT_SCALE > 1) {
      $('#my-video_html5_api').css({ transform: 'scale(' + CURRENT_SCALE + ')' });
    } else {
      isZoomed = false;
      $('#my-video_html5_api').css({ top: "0", left: "0" })
    }
  }

  let pan = function pan(ev) {
    if (ev.srcEvent.srcElement.className.split(' ').indexOf('vjs-control') !== -1) {
      console.log(ev.srcEvent.srcElement.className);
      return;
    }
    
    let currentTop = parseInt($('#my-video_html5_api').css('top'), 10);
    let currentLeft = parseInt($('#my-video_html5_api').css('left'), 10);
    
    let top = currentTop + (ev.deltaY - LAST_DELTA_Y);
    let left = currentLeft + (ev.deltaX - LAST_DELTA_X);
    
    LAST_DELTA_Y = ev.deltaY;
    LAST_DELTA_X = ev.deltaX;

    let currentWidth  = ($('#my-video_html5_api').width() * CURRENT_SCALE);
    let currentHeight = ($('#my-video_html5_api').height() * CURRENT_SCALE);

    if (isZoomed) {
      if (left <= (currentWidth / 5.6) && left >= -(currentWidth / 5.6)) {
        $('#my-video_html5_api').css({ left: left });
      }
      
      if (top <= (currentHeight / 5.6) && top >= -(currentHeight / 5.6)) {
        $('#my-video_html5_api').css({ top: top });
      }
    }
  }

  // video functions

  let play = function play(file) {
    $('#video-player').show();
    let reader = new FileReader();
    reader.onload = function(videoFile) {
      let player = videojs('my-video');
      player.src({ type: 'video/mp4', src: videoFile.target.result});
    }
    reader.readAsDataURL(file);
  }

  let rewind = function rewind(rate, ms) {
    if (!isIntervalSet) {
      let player = videojs('my-video');
      player.pause();
      player.currentTime(player.currentTime() - rate);
      playbackInterval = setInterval(function() {
        player.currentTime(player.currentTime() - rate);
      }, ms);
      isIntervalSet = true;
    }
  }

  let forward = function forward(rate, ms) {
    if (!isIntervalSet) {
      let player = videojs('my-video');
      player.pause();
      player.currentTime(player.currentTime() + rate);
      playbackInterval = setInterval(function() {
        player.currentTime(player.currentTime() + rate);
      }, ms);
      isIntervalSet = true;
    }
  }

  let resetScrobbling = function resetScrobbling() {
    clearInterval(playbackInterval);
    isIntervalSet = false;
  }

  // Catch functions

  let setCatchType = function setCatchType(element, riderType) {
    let isCatch = element.hasClass('catch') ? true : false;
    let catchType = element.data('catch-type');
    let card = $(element.parents('.card')[0]);

    card.find('.catch-type-button').each(function(index, el) {
      let button = $(el);
      button.css({
        'background-color': '#fff',
        'color': '#000'
      });
    });
    
    if (isCatch) {
      if (SA.run[riderType].catchType === catchType) {
        SA.run[riderType].catchType = null;
        return
      }
      SA.run[riderType].catchType = catchType;
      if (SA.run.header.penaltyType) {
        $('.heeler-stats').find('.catch-type-button').each(function(index, el) {
          let button = $(el);
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
      if (SA.run[riderType].penaltyType === catchType) {
        SA.run[riderType].penaltyType = null;
        return
      }

      // disable heeler stats and clear is header missed
      if (riderType === 'header' && catchType === 'missed') {
        $('.heeler-stats').find('.catch-type-button').each(function(index, el) {
          let button = $(el);
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
  }

  // hammer initialization
  let el = document.getElementById('protection');
  let hammertime = new Hammer.Manager(el)
  let panGesture   = new Hammer.Pan();
  hammertime.add([panGesture]);

  hammertime.on('pan', function(ev) {
    pan(ev);
  });

  hammertime.on('panend', function(ev) {
    LAST_DELTA_Y = 0;
    LAST_DELTA_X = 0;
  });

  $('.zoom-in').on('click tap', function(e) {
    zoomIn();
  });

  $('.zoom-out').on('click tap', function(e) {
    zoomOut()
  });

  // disable drag and drop on the window

  $(window).on('drop', function(e) {
    e.preventDefault();
    e.stopPropagation();
  });

  $(window).on('dragover', function(e) {
    e.preventDefault();
    e.stopPropagation();
  });

  // video controls

  $('.double-rewind').on('mousedown touchstart', function(e) {
    e.preventDefault();
    rewind(0.2, 125);
  });

  $('.single-rewind').on('mousedown touchstart', function(e) {
    e.preventDefault();
    rewind(0.1, 125);
  });

  $('.single-forward').on('mousedown touchstart', function(e) {
    e.preventDefault();
    forward(0.1, 125);
  });

  $('.double-forward').on('mousedown touchstart', function(e) {
    e.preventDefault();
    forward(0.2, 125);
  });

  $('.control-button').on('mouseup touchend', function(e) {
    e.preventDefault();
    resetScrobbling();
  });

  $('.upload-card').on('drop', function(e) {
    let file = e.originalEvent.dataTransfer.files[0];
    let form = new FormData();
    form.append('video', file);

    if (file.type !== 'video/mp4') {
      alert('The only file type we currently accept is MP4.');
      return;
    }

    play(file);

    $.ajax({
      type: 'POST',
      processData: false,
      contentType:  false,
      data: form,
      url: '/teamroping/upload',
      beforeSend: function(request, xhr) {        
        $('.upload-progress').show();
        $('.upload-progress .determinate').css('width', '0%');
        $('.save-button').addClass('disabled');
      },
      xhr: function() {
        let xhr = $.ajaxSettings.xhr() ;
        
        xhr.upload.onprogress = function(data){
          let perc = Math.round((data.loaded / data.total) * 100);
          $('.upload-progress .determinate').css('width', perc + '%');
        };

        return xhr;
      },
      success: function(data) {
        currentVideo = data;
        currentVideo.newUpload = true;
        $('.save-button').removeClass('disabled');
      }
    });
  });

  $('.header-stats .catch').on('click', function(e) {
    e.preventDefault();
    let element = $(this);
    setCatchType(element, 'header');
  });

  $('.header-stats .penalty').on('click', function(e) {
    e.preventDefault();
    let element = $(this);
    setCatchType(element, 'header');
  });

  $('.heeler-stats .catch').on('click', function(e) {
    e.preventDefault();
    let element = $(this);
    if (SA.run.header.penaltyType !== 'missed') {
      setCatchType(element, 'heeler');
    }
  });

  $('.heeler-stats .penalty').on('click', function(e) {
    e.preventDefault();
    let element = $(this);
    if (SA.run.header.penaltyType !== 'missed') {
      setCatchType(element, 'heeler');
    }
  });

  // Save Button
  $('.save-button').on('click', function(e) {
    e.preventDefault();

    SA.run.date = $('#date').val();
    SA.run.eventId = $('#event-select').val();
    SA.run.roping  = $('#roping').val();
    SA.run.round   = $('#round').val();
    SA.run.time    = $('#time').val();
    
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
      success: function(data) {
        window.location.replace('/profile/' + SA.humanId);
      },
      error: function(xhr, textStatus, error) {
        console.log(xhr, textStatus, error);
        alert("Something went wrong. Please contact support.");
        //window.history.back();
      }
    })
  });

  // init:

  // A video exists on load
  // let's show the video player and hide the uploader.
  if (SA.videos.length) {
    $('#video-player').show();
    let player = videojs('my-video');
    let video  = SA.videos[0];
    player.src({ type: 'video/mp4', src: video.file_url});
    player.play();
  }

  // Create SA.run object if we don't have one
  if (!SA.run) {
    SA.run = {
      header: {},
      heeler: {}
    }
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