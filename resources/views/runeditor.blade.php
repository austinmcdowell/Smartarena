@extends('layouts.app')

@section('css')
<link href="https://vjs.zencdn.net/6.6.3/video-js.css" rel="stylesheet">
<link href="/css/runeditor.css" rel="stylesheet" type="text/css">
<link href="/css/videoplayer.css" rel="stylesheet" type="text/css">
@endsection

@section('content')
<run-editor></run-editor>
@endsection

@section('javascript')
<script>

  window.SA = {};
  SA.humanId = @json($human_id);
  SA.humans = @json($humans);
  SA.videos = @json($videos);
  SA.events = @json($events);
  @if (isset($run))
  SA.rawRun = @json($run);
  @endif

</script>
<script src="https://vjs.zencdn.net/6.6.3/video.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<!-- <script src="/js/runeditor.js"></script> -->
<!-- <script src="/js/videoplayer.js"></script> -->
@endsection
