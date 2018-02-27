@extends('layouts.app')

@section('css')
<style>
  .login-button {
    display:block;
  }
</style>
@endsection

@section('content')
  <br />
  <div class="row">
    <div class="col s10 offset-s1 l4 offset-l4">
      <div class="card">
        <div class="card-content">
          <a href="/login/google" class="login-button waves-effect waves-light btn">Login with Google</a>
        </div>
      </div>
    </div>
      
@endsection