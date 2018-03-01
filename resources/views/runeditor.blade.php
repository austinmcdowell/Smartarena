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
  <div class="col s12 offset-l3 l6">
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
<div class="row">
  <div class="col s12">
    <div class="card header-stats">
      <div class="card-content">
        <h4>Header Stats</h4>
        <div class="row">
          <div class="col s4 center-align">
            <div class="catch-type-button catch" data-catch-type="half head">
              <span>Half Head</span>
            </div>
          </div>
          <div class="col s4 center-align">
            <div class="catch-type-button catch" data-catch-type="two horns">
              <span>Two Horns</span>
            </div>
          </div>
          <div class="col s4 center-align">
            <div class="catch-type-button catch" data-catch-type="slick horns">
              <span>Slick Horns</span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col s12 center-align">
            <div class="catch-type-button penalty" data-catch-type="missed">
              <span>Missed</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col s12">
    <div class="card heeler-stats">
      <div class="card-content">
        <h4>Heeler Stats</h4>
        <div class="row">
          <div class="col s6 center-align">
            <div class="catch-type-button catch" data-catch-type="clean">
              <span>Clean</span>
            </div>
          </div>
          <div class="col s6 center-align">
            <div class="catch-type-button penalty" data-catch-type="leg">
              <span>Leg</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col s12">
    <div class="card details">
      <div class="card-content">
        <h4>Details</h4>
        <form class="col s12">
          <div class="row">
            <div class="col s12 input-field">
              <input placeholder="Date" id="date" type="text">
            </div>
          </div>
          <div class="row">
            <div class="col s12 input-field">
              <select id="event-select">
                <option value="" disabled selected>Choose your option</option>
                @foreach ($events as $event)
                  <option value="{{ $event->id }}">{{ $event->location }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col s12 input-field">
              <input placeholder="Roping" id="roping" type="text" class="validate">
            </div>
          </div>
          <div class="row">
            <div class="col s12 input-field">
              <input placeholder="Round" id="round" type="text" class="validate">
            </div>
          </div>
          <div class="row">
            <div class="col s12 input-field">
              <input placeholder="Time" id="time" type="text" class="validate">
            </div>
          </div>
          <div class="row">
            <div class="col s6 center-align">
              <input type="checkbox" id="no-time" />
              <label for="no-time">No Time</label>
            </div>
            <div class="col s6 center-align">
              <input type="checkbox" id="score" />
              <label for="score">Score</label>
            </div>
          </div>
          <div class="row">
            <div class="col s12 input-field">
              <h5>Header Select</h5>
              <select id="header-select">
                <option value="" disabled selected>Choose Header</option>
                @foreach ($humans as $human)
                  <option value="{{ $human->id }}">{{ $human->first_name . " " . $human->last_name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col s12 input-field">
              <select id="header-barrier-penalty">
                <option value="0" selected>No Barrier Penalty</option>
                <option value="5">5 Seconds</option>
                <option value="10">10 Seconds</option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col s12 input-field">
              <h5>Heeler Select</h5>
              <select id="heeler-select">
                <option value="" disabled selected>Choose Heeler</option>
                @foreach ($humans as $human)
                  <option value="{{ $human->id }}">{{ $human->first_name . " " . $human->last_name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col s12 input-field">
              <select id="heeler-barrier-penalty">
                <option value="0" selected>No Barrier Penalty</option>
                <option value="5">5 Seconds</option>
                <option value="10">10 Seconds</option>
              </select>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


@endsection

@section('javascript')
<script>

  let SA = {};
  SA.videos = @json($videos);
  @if (isset($run))
  SA.run = @json($run);
  @endif

</script>
<script src="http://vjs.zencdn.net/6.6.3/video.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script src="/js/runeditor.js"></script>
@endsection
