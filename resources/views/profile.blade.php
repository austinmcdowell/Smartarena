@extends('layouts.app')

@section('css')
<link href="/css/profile.css" rel="stylesheet" type="text/css">
@endsection


@section('content')
  <div class="row">
      <div class="col s12 banner">
        <div class="teamroping-header"></div>
      </div>
  </div>
  <div class="row">
      <div class="col s2">
        <div class="user-image"></div>
      </div>
      <div class="col s4">
        <h1 class="human-name">{{ $human->first_name . ' ' . $human->last_name }}</h1>
        <span class="sport-title">Sport: Team Roping</span>
        <span class="location">Location: {{ $human->location }}</span>
      </div>
      <div class="col offset-s3 s2 actions">
        <a href="/teamropingrun/new?humanId={{ $human->id }}" class="waves-effect waves-light btn">Add Run</a>
      </div>
  </div>
  <div class="row">
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
                  <td><a href="/teamropingrun/{{ $run->id }}/edit"><i class="material-icons">edit</i></a></td>
                  <td><a href="#"><i class="material-icons">play_arrow</i></a></td>
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
  <div class="row">
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
                  <td><a href="/teamropingrun/{{ $run->id }}/edit"><i class="material-icons">edit</i></a></td>
                  <td><a href="#"><i class="material-icons">play_arrow</i></a></td>
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
@endsection