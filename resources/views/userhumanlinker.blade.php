@extends('layouts.app')

@section('css')
<link href="/css/userhumanlinker.css" rel="stylesheet" type="text/css">
@endsection

@section('content')
<br />
<div class="row">
  <div class="col s8 offset-s2">
    <div class="card">
      <div class="card-content">
        <h3>User Human Linker</h3>
        <div class="input-field col s12">
          <select id="user-select">
            <option value="" disabled selected>Choose user</option>
            @foreach ($users as $user)
              <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
          </select>
        </div>

        <div class="input-field col s12">
          <select id="human-select">
            <option value="" disabled selected>Choose human</option>
            @foreach ($humans as $human)
              <option value="{{ $human->id }}">{{ $human->first_name . " " . $human->last_name }}</option>
            @endforeach
          </select>
        </div>
        <br />
        <div class="col s4 offset-s4">
          <button class="waves-effect waves-light btn link-button">Link User and Human</button>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('javascript')
<script src="/js/userhumanlinker.js"></script>
@endsection