@extends('layouts.app')

@section('css')
<link href="http://vjs.zencdn.net/6.6.3/video-js.css" rel="stylesheet">
<link href="/css/runeditor.css" rel="stylesheet" type="text/css">
@endsection

@section('content')
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
<div class="row video-uploader">
  <div class="col offset-s3 s6">
    <div class="card upload-card">
      <div class="card-content">
        <div class="input-field col s12 file-upload">
          <input id="file" name="file" type="file">
          <label for="file">Upload Your Video (not required)</label>
        </div>
        <div class="progress upload-progress">
            <div class="determinate" style="width: 0%"></div>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection

@section('javascript')
<script>

  let SA = {};
  SA.videos = @json($videos);

</script>
<script src="http://vjs.zencdn.net/6.6.3/video.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script src="/js/runeditor.js"></script>
@endsection
