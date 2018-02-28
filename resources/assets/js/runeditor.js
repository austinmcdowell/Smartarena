$(document).ready(function() {
  let videoHeight = $('#my-video').height();
  let videoWidth  = $('#my-video').width();
  
  let LAST_DELTA_X = 0;
  let LAST_DELTA_Y = 0;
  let CURRENT_SCALE = 1;
  let isZoomed = false;

  let currentVideo = null;
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
      }
    });

  });

  // init:

  // A video exists on load
  // let's show the video player and hide the uploader.
  if (SA.videos.length) {
    $('#video-player').show();
  }


});