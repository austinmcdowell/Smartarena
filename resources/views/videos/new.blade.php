@extends('layouts.app')

@section('css')
<link href="/css/runeditor.css" rel="stylesheet" type="text/css">
<link href="/css/videoplayer.css" rel="stylesheet" type="text/css">
@endsection

@section('content')
<video-uploader></video-uploader>
@endsection

@section('javascript')
<script>

  window.SA = {};
  SA.humanId = @json($human_id);

</script>
@endsection