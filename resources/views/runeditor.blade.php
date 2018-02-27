@extends('layouts.app')

@section('css')
<link href="http://vjs.zencdn.net/6.6.3/video-js.css" rel="stylesheet">
<link href="/css/runeditor.css" rel="stylesheet" type="text/css">
@endsection

@section('content')
<div id="protection">
  <video id="my-video" class="video-js" autoplay controls data-setup="{}" playsinline>
      <source src="https://storage.googleapis.com/smartarena-client.appspot.com/tr-clips/MzE3YzQzYjY0NDUxYWYwNTU3MTRlYjgyNmQ3ZDc5YTU=.mp4" type='video/mp4'>
      <p class="vjs-no-js">
        To view this video please enable JavaScript, and consider upgrading to a web browser that
        <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
      </p>
    </video>
</div>
<div class="row">
  <div class="col s6 zoom-button center-align">
    <span class="zoom-in">+</span>
  </div>
  <div class="col s6 zoom-button center-align">
    <span class="zoom-out">-</span>
  </div>
</div>
@endsection

@section('javascript')
<script src="http://vjs.zencdn.net/6.6.3/video.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script src="/js/runeditor.js"></script>
@endsection
