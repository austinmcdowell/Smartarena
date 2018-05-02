<template>
  <div id="video-player">
    <div id="protection">
      <video id="my-video" class="video-js" autoplay controls data-setup="{}" playsinline>
        <p class="vjs-no-js">
          To view this video please enable JavaScript, and consider upgrading to a web browser that
          <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
        </p>
      </video>
    </div>
    <div class="row zoom-panel">
      <div class="col s6 zoom-button center-align">
        <span class="zoom-in">+</span>
      </div>
      <div class="col s6 zoom-button center-align">
        <span class="zoom-out">-</span>
      </div>
    </div>
    <div class="row">
      <div class="col s3 control-button center-align double-rewind">
        <span><i class="fas fa-angle-double-left"></i></span>
      </div>
      <div class="col s3 control-button center-align single-rewind">
        <span><i class="fas fa-angle-left"></i></span>
      </div>
      <div class="col s3 control-button center-align single-forward">
        <span><i class="fas fa-angle-right"></i></span>
      </div>
      <div class="col s3 control-button center-align double-forward">
        <span><i class="fas fa-angle-double-right"></i></span>
      </div>
    </div>
  </div>
</template>
<script>
  import EventBus from './EventBus';

  export default {
    mounted() {
      this.player = videojs('my-video');
      this.videoHeight = $('#my-video').height();
      this.videoWidth = $('#my-video').width();

      let $this = this;
      let el = document.getElementById('protection');
      let hammertime = new Hammer.Manager(el)
      let panGesture = new Hammer.Pan();
      hammertime.add([panGesture]);

      hammertime.on('pan', function(ev) { $this.pan(ev); });

      hammertime.on('panend', function(ev) {
        $this.lastDeltaX = 0;
        $this.lastDeltaY = 0;
      });

      $('.zoom-in').on('click tap', function(e) { $this.zoomIn(); });
      $('.zoom-out').on('click tap', function(e) { $this.zoomOut(); });

      $('.double-rewind').on('mousedown touchstart', function(e) {
        e.preventDefault();
        $this.rewind(0.2, 125);
      });

      $('.single-rewind').on('mousedown touchstart', function(e) {
        e.preventDefault();
        $this.rewind(0.1, 125);
      });

      $('.single-forward').on('mousedown touchstart', function(e) {
        e.preventDefault();
        $this.forward(0.1, 125);
      });

      $('.double-forward').on('mousedown touchstart', function(e) {
        e.preventDefault();
        $this.forward(0.2, 125);
      });

      $('.control-button').on('mouseup touchend', function(e) {
        e.preventDefault();
        $this.resetScrobbling();
      });

      EventBus.$on('videoSourceChange', function(data) {
        $this.setSource(data);
      });

      this.player.on('timeupdate', function() {
        $this.currentScrobbleTime = $this.player.currentTime();
      });
    },
    data() {
      return {
        player: null,
        videoSource: {},
        videoHeight: null,
        videoWidth: null,
        lastDeltaX: 0,
        lastDeltaY: 0,
        currentScale: 1,
        isZoomed: false,
        playbackInterval: null,
        isIntervalSet: false,
        currentScrobbleTime: 0
      }
    },
    watch: {
      currentScale: function(currentScale) {
        if (currentScale > 1) {
          $('#my-video_html5_api').css({ transform: 'scale(' + currentScale + ')' });
        } else {
          this.isZoomed = false;
          $('#my-video_html5_api').css({ top: "0", left: "0" })
        }
      }
    },
    methods: {
      rewind: function(rate, ms) {
        if (!this.isIntervalSet) {
          this.player.pause();
          this.player.currentTime(this.player.currentTime() - rate);
          this.playbackInterval = setInterval(function() {
             this.player.currentTime(this.player.currentTime() - rate);
          }, ms);
          this.isIntervalSet = true;
        }
      },
      forward: function(rate, ms) {
        if (!this.isIntervalSet) {
          this.player.pause();
          this.player.currentTime(this.player.currentTime() + rate);
          this.playbackInterval = setInterval(function() {
            this.player.currentTime(this.player.currentTime() + rate);
          }, ms);
          this.isIntervalSet = true;
        }
      },
      zoomIn() {
        if (this.currentScale < 1) {
          return;
        }
        this.currentScale += 0.1;
        this.isZoomed = true;
      },
      zoomOut() {
        if (this.currentScale === 1) {
          return;
        }

        this.currentScale -= 0.1;
      },
      pan: function(ev) {
        console.log('stuff is happening');
      },
      resetScrobbling() {
        clearInterval(this.playbackInterval);
        this.isIntervalSet = false;
      },
      setSource: function(videoData) {
        this.player.src({ type: 'video/mp4', src: videoData.file_url });
        this.player.play();
      },
      getCurrentScrobbleTime() {
        return this.currentScrobbleTime;
      }
    }
  }
</script>