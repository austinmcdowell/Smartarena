@extends('layouts.app')

@section('css')
<link href="http://vjs.zencdn.net/6.6.3/video-js.css" rel="stylesheet">
<link href="/css/profile.css" rel="stylesheet" type="text/css">
<link href="/css/videoplayer.css" rel="stylesheet" type="text/css">
@endsection


@section('content')
  <div class="row">
      <div class="col s12 banner">
        <div class="teamroping-header"></div>
      </div>
  </div>
  <div class="row hide-on-large-only">
    <div class="col s12">
      <div class="user-image"></div>
    </div>
  </div>
  <div class="row hide-on-large-only">
    <div class="col s12 center-align">
      <h1 class="human-name">{{ $human->first_name . ' ' . $human->last_name }}</h1>
      <span class="sport-title">Sport: Team Roping</span>
      <span class="location">Location: {{ $human->location }}</span>
    </div>
  </div>
  <div class="row hide-on-large-only">
    @if (isset($isLoggedIn) && $isLoggedIn && $human->user_id == $user->id)
    <div class="col offset-s2 s8 actions">
      <a href="/teamroping/new" class="waves-effect waves-light btn">Add Run</a>
    </div>
    @endif
  </div>

  <div class="row hide-on-med-and-down">
      <div class="col offset-s1 s2">
        <div class="user-image"></div>
      </div>
      <div class="col s4">
        <h1 class="human-name">{{ $human->first_name . ' ' . $human->last_name }}</h1>
        <span class="sport-title">Sport: Team Roping</span>
        <span class="location">Location: {{ $human->location }}</span>
      </div>
      @if (isset($isLoggedIn) && $isLoggedIn && $human->user_id == $user->id)
      <div class="col offset-s2 s2 actions">
        <a href="/teamroping/new" class="waves-effect waves-light btn">Add Run</a>
      </div>
      @endif
  </div>
  <!-- Header Runs -->
  @if (!$header_runs->isEmpty())
  <div class="row hide-on-large-only center-align">
    <div class="col s10 offset-s1">
      <h4>Header Runs</h4>
    </div>
  </div>
  <div class="row hide-on-large-only">
    @foreach ($header_runs as $run)
    <div class="col s10 offset-s1">
      <div class="card">
        <div class="card-content">
          <div class="row">
            <div class="col s12">
              <p>Date: {{ $run->date }}</p>
              <p>Event: {{ $run->event->location }} </p>
              <p>Header Catch: {{ $run->header_catch_type }}</p>
              <p>Heeler Catch: {{ $run->heeler_catch_type }}</p>
              <p>Header Penalty: {{ $run->header_penalty_type }}</p>
              <p>Penalties: {{ $run->header_penalty_time }}</p>
              <p>Total Run Penalties: {{ $run->header_penalty_time + $run->heeler_penalty_time }}</p>
              <p>Raw Time: {{ $run->raw_time }}</p>
              <p>Total Time: {{ $run->total_time }}</p>
            </div>
          </div>
          @if (isset($isLoggedIn) && $isLoggedIn && $human->user_id == $user->id)
          <div class="row">
            <div class="col s12 center-align">
              <a href="/teamroping/{{ $run->id }}/edit" class="waves-effect waves-light btn">Edit Run</a>
            </div>
          </div>
          @endif
          @if ($run->videos->first())
          <div class="row">
            <div class="col s12 center-align">
              @if ($run->videos->first()->processing_complete)
              <a class="waves-effect waves-light btn play-button" href="#" data-video-url="{{$run->videos->first()->file_url}}">Play Video</a>
              @else
              <a class="waves-effect waves-light btn disabled" href="#">Processing...</a>
              @endif
            </div>
          </div>
          @endif
        </div>
      </div>
    </div>
    @endforeach
  </div>
  <div class="row hide-on-med-and-down">
    <div class="col s10 offset-s1">
      <div class="card">
        <div class="card-content">
          
          <table>
            <thead>
              <tr>
                <th></th>
                <th></th>
                <th>Date</th>
                <th>Event</th>
                <th>Header Catch</th>
                <th>Heeler Catch</th>
                <th>Header Penalty</th>
                <th>Penalties</th>
                <th>Total Run Penalties</th>
                <th>Raw Time</th>
                <th>Total Time</th>
              </tr>
            </thead>
    
            <tbody>
              @foreach ($header_runs as $run)
                <tr>
                  <td><a href="/teamroping/{{ $run->id }}/edit"><i class="material-icons">edit</i></a></td>
                  @if ($run->videos->first() && $run->videos->first()->processing_complete)
                  <td><a class="play-button" href="#" data-video-url="{{$run->videos->first()->file_url}}"><i class="material-icons">play_arrow</i></a></td>
                  @elseif ($run->videos->first() && !$run->videos->first()->processing_complete)
                  <td><i class="material-icons">alarm</i></td>
                  @endif
                  <td>{{ $run->date }}</td>
                  <td>{{ $run->event->location }} </td>
                  <td>{{ $run->header_catch_type }}</td>
                  <td>{{ $run->heeler_catch_type }}</td>
                  <td>{{ $run->header_penalty_type }}</td>
                  <td>{{ $run->header_penalty_time }}</td>
                  <td>{{ $run->header_penalty_time + $run->heeler_penalty_time }}</td>
                  <td>{{ $run->raw_time }}</td>
                  <td>{{ $run->total_time }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  @endif

  <!-- Heeler Runs -->
  @if (!$heeler_runs->isEmpty())
  <div class="row hide-on-large-only center-align">
    <div class="col s10 offset-s1">
      <h4>Heeler Runs</h4>
    </div>
  </div>
  <div class="row hide-on-large-only">
    @foreach ($heeler_runs as $run)
    <div class="col s10 offset-s1">
      <div class="card">
        <div class="card-content">
          <div class="row">
            <div class="col s12">
              <p>Date: {{ $run->date }}</p>
              <p>Event: {{ $run->event->location }} </p>
              <p>Header Catch: {{ $run->header_catch_type }}</p>
              <p>Heeler Catch: {{ $run->heeler_catch_type }}</p>
              <p>Header Penalty: {{ $run->heeler_penalty_type }}</p>
              <p>Penalties: {{ $run->heeler_penalty_time }}</p>
              <p>Total Run Penalties: {{ $run->header_penalty_time + $run->heeler_penalty_time }}</p>
              <p>Raw Time: {{ $run->raw_time }}</p>
              <p>Total Time: {{ $run->total_time }}</p>
            </div>
          </div>
          @if (isset($isLoggedIn) && $isLoggedIn && $human->user_id == $user->id)
          <div class="row">
            <div class="col s12 center-align">
              <a href="/teamroping/{{ $run->id }}/edit" class="waves-effect waves-light btn">Edit Run</a>
            </div>
          </div>
          @endif
          @if ($run->videos->first() && $run->videos->first()->processing_complete)
          <div class="row">
            <div class="col s12 center-align">
              @if ($run->videos->first()->processing_complete)
              <a class="waves-effect waves-light btn play-button" href="#" data-video-url="{{$run->videos->first()->file_url}}">Play Video</a>
              @else
              <a class="waves-effect waves-light btn disabled" href="#">Processing...</a>
              @endif
            </div>
          </div>
          @endif
        </div>
      </div>
    </div>
    @endforeach
  </div>
  <div class="row hide-on-med-and-down">
    <div class="col s10 offset-s1">
      <div class="card">
        <div class="card-content">
          <h4>Heeler Runs</h4>
          <table>
            <thead>
              <tr>
                <th></th>
                <th></th>
                <th>Date</th>
                <th>Event</th>
                <th>Header Catch</th>
                <th>Heeler Catch</th>
                <th>Heeler Penalty</th>
                <th>Penalties</th>
                <th>Total Run Penalties</th>
                <th>Raw Time</th>
                <th>Total Time</th>
              </tr>
            </thead>
    
            <tbody>
              @foreach ($heeler_runs as $run)
                <tr>
                  <td><a href="/teamroping/{{ $run->id }}/edit"><i class="material-icons">edit</i></a></td>
                  @if ($run->videos->first() && $run->videos->first()->processing_complete)
                  <td><a class="play-button" href="#" data-video-url="{{$run->videos->first()->file_url}}"><i class="material-icons">play_arrow</i></a></td>
                  @elseif ($run->videos->first() && !$run->videos->first()->processing_complete)
                  <td><i class="material-icons">alarm</i></td>
                  @endif
                  <td>{{ $run->date }}</td>
                  <td>{{ $run->event->location }} </td>
                  <td>{{ $run->header_catch_type }}</td>
                  <td>{{ $run->heeler_catch_type }}</td>
                  <td>{{ $run->heeler_penalty_type }}</td>
                  <td>{{ $run->heeler_penalty_time }}</td>
                  <td>{{ $run->header_penalty_time + $run->heeler_penalty_time }}</td>
                  <td>{{ $run->raw_time }}</td>
                  <td>{{ $run->total_time }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  @endif

  <div id="video-modal" class="modal">
    <div class="modal-content">
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
  </div>

  @if ($header_runs->isEmpty() && $heeler_runs->isEmpty())
  <div class="row center-align">
    <div class="col s10 offset-s1">
      <h5>This person doesn't have any runs yet!</h5>
    </div>
  </div>
  @endif
@endsection

@section('javascript')
<script src="http://vjs.zencdn.net/6.6.3/video.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js"></script>
<script src="/js/profile.js"></script>
<script src="/js/videoplayer.js"></script>
@endsection