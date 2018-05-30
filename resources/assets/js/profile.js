$(document).ready(function() {
  let player = videojs('my-video');

  var elem = document.querySelector('.modal');
  var instance = M.Modal.init(elem, {
    complete: function() {
      player.pause();
    }
  });

  $('.play-button').on('click', function(e) {
    e.preventDefault();
    let videoUrl = $(this).data('video-url');
    player.src({ type: 'video/mp4', src: videoUrl });
    player.play();
    instance.open();
  });
});