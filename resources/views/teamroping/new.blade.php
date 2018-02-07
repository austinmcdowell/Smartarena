@extends('layouts.app')

@section('css')
<link href="/css/lib/materialize-stepper.min.css" rel="stylesheet" type="text/css">
@endsection

@section('content')
<div class="row">
  <div class="col offset-s3 s6">
    <ul class="stepper linear horizontal">
      <li class="step active">
          <div class="step-title waves-effect">Create a run</div>
          <div class="step-content">
            <div class="row">
                <div class="input-field col s12">
                  <input placeholder="Placeholder" id="date" type="text" class="validate">
                  <label for="date">Date</label>
                </div>
            </div>

            <div class="row">
              <div class="input-field col s12">
                <select id="event-select">
                  <option value="" disabled selected>Choose Event</option>
                  @foreach ($events as $event)
                    <option value="{{ $event->id }}">{{ $event->data . ' ' . $event->location }}</option>
                  @endforeach
                </select>
                <br />
              </div>
            </div>

            <div class="row">
                <div class="input-field col s12">
                  <input placeholder="Placeholder" id="roping" type="text" class="validate">
                  <label for="roping">Roping</label>
                </div>
            </div>

            <div class="row">
                <div class="input-field col s12">
                  <input placeholder="Placeholder" id="round" type="text" class="validate">
                  <label for="round">Round</label>
                </div>
            </div>

            <div class="row">
                <div class="input-field col s12">
                  <input placeholder="Placeholder" id="time" type="text" class="validate">
                  <label for="time">Time</label>
                </div>
            </div>

            <div class="row">
              <div class="col s12">
                <h3>Header</h3>
              </div>
            </div>

            <div class="row">
              <div class="input-field col s12">
                <select id="header-select">
                  <option value="" disabled selected>Select Header</option>
                  @foreach ($humans as $human)
                    <option value="{{ $human->id }}">{{ $human->first_name . ' ' . $human->last_name }}</option>
                  @endforeach
                </select>
                <br />
              </div>
            </div>

            <div class="row">
                <div class="input-field col s12">
                  <input type="checkbox" class="filled-in" id="header_did_catch" checked="checked" />
                  <label for="header_did_catch">Header Catch</label>
                </div>
            </div>

            <div class="row">
              <div class="col s12">
                <h3>Heeler</h3>
              </div>
            </div>

            <div class="row">
              <div class="input-field col s12">
                <select id="heeler-select" class="human-select">
                  <option value="" disabled selected>Select Heeler</option>
                  @foreach ($humans as $human)
                    <option value="{{ $human->id }}">{{ $human->first_name . ' ' . $human->last_name }}</option>
                  @endforeach
                </select>
                <br />
              </div>
            </div>

            <div class="row">
                <div class="input-field col s12">
                  <input type="checkbox" class="filled-in" id="heeler_did_catch" checked="checked" />
                  <label for="heeler_did_catch">Heeler Catch</label>
                </div>
            </div>

            <div class="row">
              <div class="col s12">
                  <br />
                  <button class="waves-effect waves-dark btn next-step">CONTINUE</button>
              </div>
            </div>
            
          </div>
      </li>
      <li class="step">
          <div class="step-title waves-effect">Upload Video</div>
          <div class="step-content">
            <div class="row">
                <div class="input-field col s12">
                  <input id="password" name="password" type="password" class="validate" required>
                  <label for="password">Your password</label>
                </div>
            </div>
            <div class="step-actions">
                <button class="waves-effect waves-dark btn">Finish</button>
                <button class="waves-effect waves-dark btn-flat previous-step">BACK</button>
            </div>
          </div>
      </li>
    </ul>
  </div>
</div>
@endsection

@section('javascript')
<script src="/js/lib/materialize-stepper.min.js"></script>
<script src="/js/teamroping/new.js"></script>
@endsection
