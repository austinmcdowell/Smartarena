$(document).ready(function() {

  let videoHeight = $('#my-video').height();
  let videoWidth  = $('#my-video').width();
  
  let LAST_DELTA_X = 0;
  let LAST_DELTA_Y = 0;

  let CURRENT_SCALE = 1;

  let isZoomed = false;
  let el = document.getElementById('protection');

  let hammertime = new Hammer.Manager(el)
  let pan   = new Hammer.Pan();

  hammertime.add([pan]);

  hammertime.on('pan', function(ev) {
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
  });

  hammertime.on('panend', function(ev) {
    LAST_DELTA_Y = 0;
    LAST_DELTA_X = 0;
  });

  $('.zoom-in').on('click tap', function(e) {
    e.preventDefault();
    
    if (CURRENT_SCALE < 1) {
        return;
      }

      CURRENT_SCALE += 0.1;
      
      isZoomed = true;
      $('#my-video_html5_api').css({ transform: 'scale(' + CURRENT_SCALE + ')' });
  });

  $('.zoom-out').on('click tap', function(e) {
    e.preventDefault();

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
  });
});