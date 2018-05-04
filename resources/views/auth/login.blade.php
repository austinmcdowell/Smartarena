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
<div class="container">
    <div class="row">
        <div class="col s10 offset-s1 l12">
            <div class="card">
                <div class="card-content">
                <a href="/login/google" class="login-button google waves-effect waves-light btn">Login with Google</a>
                <!-- We have some code in place to start adding facebook authentication, but we need to do checks to make sure that
                if users have signed in with google we link the accounts instead of creating a new one -->
                <a href="/login/facebook" class="login-button facebook waves-effect waves-light btn">Login with Facebook</a>
                </div>
            </div>
        </div>
        <div class="col s10 offset-s1 l12">
            <div class="card">
                <div class="card-content">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-sm-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            </div>
                        </div>
                    </form>
                    <p>Don't have an account? <a href="/register">Create one here.</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
