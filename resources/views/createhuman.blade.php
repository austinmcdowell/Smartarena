@extends('layouts.app')

@section('content')
<br />
<div class="row">
  <div class="col s8 offset-s2">
    <div class="card">
      <div class="card-content">
        <h3>Create Human Record</h3>

        <form class="col s12">
          <div class="row">
            <div class="col s12 input-field">
              <input placeholder="Classification" id="classification" type="number">
              <label for="classification">Classification</label>
            </div>
          </div>
          <div class="row">
            <div class="col s12 input-field">
              <input placeholder="First Name" id="first_name" type="text">
              <label for="first_name">First Name</label>
            </div>
          </div>
          <div class="row">
            <div class="col s12 input-field">
              <input placeholder="Last Name" id="last_name" type="text">
              <label for="last_name">Last Name</label>
            </div>
          </div>
          <div class="row">
            <div class="col s12 input-field">
              <input placeholder="Location" id="location" type="text">
              <label for="location">Location</label>
            </div>
          </div>
        </form>

        <button class="waves-effect waves-light btn upload-button">Save Human</button>

      </div>
    </div>
  </div>
</div>
@endsection

@section('javascript')
<script src="/js/createhuman.js"></script>
@endsection