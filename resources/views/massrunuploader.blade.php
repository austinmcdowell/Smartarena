@extends('layouts.app')

@section('css')
<link href="/css/massrunuploader.css" rel="stylesheet" type="text/css">
@endsection

@section('content')
<br />
<div class="row">
  <div class="col s8 offset-s2">
    <div class="card">
      <div class="card-content">
        <h3>Mass Run Uploader</h3>
        <div class="input-field col s12">
          <select id="event-select">
            <option value="" disabled selected>Choose your option</option>
            @foreach ($events as $event)
              <option value="{{ $event->id }}">{{ $event->location }}</option>
            @endforeach
          </select>
        </div>

        <div class="input-field col s12">
          <textarea id="textarea1" class="materialize-textarea csv-textarea"></textarea>
          <label for="textarea1">Paste Your Roping Data Here</label>
        </div>

        <button class="waves-effect waves-light btn upload-button">Upload CSV</button>

      </div>
    </div>
  </div>
</div>
@endsection

@section('javascript')
<script src="/js/massrunuploader.js"></script>
@endsection