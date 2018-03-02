$(document).ready(function() {
  let player = videojs('my-video');
  
  $('#video-modal').modal({
    complete: function() {
      player.pause();
    }
  });

  $('.play-button').on('click', function(e) {
    e.preventDefault();
    let videoUrl = $(this).data('video-url');
    $('#video-modal').modal('open')
    player.src({ type: 'video/mp4', src: videoUrl });
  });
});