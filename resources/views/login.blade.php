@extends('layouts.app')

@section('css')
<style>
  .login-button {
    display:block;
  }

  .facebook {
    margin-top:20px;
  }
</style>
@endsection

@section('content')
  <br />
  <div class="row">
    <div class="col s10 offset-s1 l4 offset-l4">
      <div class="card">
        <div class="card-content">
          <a href="/login/google" class="login-button google waves-effect waves-light btn">Login with Google</a>
          <!-- We have some code in place to start adding facebook authentication, but we need to do checks to make sure that
          if users have signed in with google we link the accounts instead of creating a new one -->
          <a href="/login/facebook" class="login-button facebook waves-effect waves-light btn">Login with Facebook</a>
        </div>
      </div>
    </div>
      
@endsection