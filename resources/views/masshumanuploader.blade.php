@extends('layouts.app')

@section('content')
<br />
<div class="row">
  <div class="col s8 offset-s2">
    <div class="card">
      <div class="card-content">
        <h3>Mass Upload Human Records</h3>

        <div class="input-field col s12">
          <textarea id="textarea1" class="materialize-textarea csv-textarea"></textarea>
          <label for="textarea1">Paste your human records here</label>
        </div>

        <button class="waves-effect waves-light btn upload-button">Upload CSV</button>

      </div>
    </div>
  </div>
</div>
@endsection

@section('javascript')
<script src="/js/masshumanuploader.js"></script>
@endsection