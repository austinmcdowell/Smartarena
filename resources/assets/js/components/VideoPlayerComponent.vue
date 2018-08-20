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
    <div class="container-fluid">
      <div class="row zoom-panel">
        <div @click="togglePlay()" class="col-4 col-sm-4 video-control-button text-center">
          <span><i v-show="!isPlaying" class="fas fa-play"></i><i v-show="isPlaying" class="fas fa-pause"></i></span>
        </div>
        <div class="col-4 col-sm-4 zoom-button text-center">
          <span class="zoom-out"><i class="fas fa-minus"></i></span>
        </div>
        <div class="col-4 col-sm-4 zoom-button text-center">
          <span class="zoom-in"><i class="fas fa-plus"></i></span>
        </div>
      </div>
      <div class="row">
        <div class="col-3 col-sm-3 control-button text-center double-rewind">
          <span><i class="fas fa-angle-double-left"></i></span>
        </div>
        <div class="col-3 col-sm-3 control-button text-center single-rewind">
          <span><i class="fas fa-angle-left"></i></span>
        </div>
        <div class="col-3 col-sm-3 control-button text-center single-forward">
          <span><i class="fas fa-angle-right"></i></span>
        </div>
        <div class="col-3 col-sm-3 control-button text-center double-forward">
          <span><i class="fas fa-angle-double-right"></i></span>
        </div>
      </div>
    </div>
    <!-- <h2 class="video-title">Test Title</h2> -->
  </div>
    
</template>
<script>
  import EventBus from './EventBus';

  export default {
    props: ['videoId'],
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

      this.player.on('pause', function() {
        $this.isPlaying = false;
      });

      this.player.on('play', function() {
        $this.isPlaying = true;
      });

      this.player.on('timeupdate', function() {
        $this.currentScrobbleTime = $this.player.currentTime();
      });
    },
    data() {
      return {
        playingVideoId: this.videoId,
        player: null,
        videoSource: {},
        videoHeight: null,
        videoWidth: null,
        lastDeltaX: 0,
        lastDeltaY: 0,
        currentScale: 1,
        isZoomed: false,
        isPlaying: true,
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
      },
      videoId: function(videoId) {
        this.playingVideoId = videoId;
      },
      playingVideoId: function(videoId) {
        console.log('im here');
        const $this = this;
        axios.get(`/video/data/${videoId}`).then(response => {
          let data = response.data;
          console.log(data);
          window.player = $this.player;
          $this.player.src({ type: 'video/mp4', src: data.file_url });
          $this.player.play();
        }).catch(e => {
          console.log(e);
          // window.history.back();
        });
      }
    },
    methods: {
      togglePlay() {
        if (this.isPlaying) {
          this.player.pause();
        } else {
          this.player.play();
        }
      },
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
        if (ev.srcEvent.srcElement.className.split(' ').indexOf('vjs-control') !== -1) {
          console.log(ev.srcEvent.srcElement.className);
          return;
        }
        
        let currentTop = parseInt($('#my-video_html5_api').css('top'), 10);
        let currentLeft = parseInt($('#my-video_html5_api').css('left'), 10);
        
        let top = currentTop + (ev.deltaY - this.lastDeltaY);
        let left = currentLeft + (ev.deltaX - this.lastDeltaX);
        
        this.lastDeltaY = ev.deltaY;
        this.lastDeltaX = ev.deltaX;

        let currentWidth  = ($('#my-video_html5_api').width() * this.currentScale);
        let currentHeight = ($('#my-video_html5_api').height() * this.currentScale);

        if (this.isZoomed) {
          if (left <= (currentWidth / 5.6) && left >= -(currentWidth / 5.6)) {
            $('#my-video_html5_api').css({ left: left });
          }
          
          if (top <= (currentHeight / 5.6) && top >= -(currentHeight / 5.6)) {
            $('#my-video_html5_api').css({ top: top });
          }
        }
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