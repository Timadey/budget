@extends('layouts.auth')

@section ('content')
<h3 class="card-title text-left mb-3">Login</h3>
  <form method="POST" action= "{{('login')}}">
    @csrf

    <div class="form-group">
      <label>Email *</label>
      <input id="email" type="email" class="form-control p_input @error('email') is-invalid @enderror" value="{{old('email')}}" name="email" required autocomplete="email" autofocus>
      @error('email')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
      @enderror
    </div>

    <div class="form-group">
      <label>Password *</label>
      <input id="password" type="password" class="form-control @error('password') is-invalid @enderror p_input " name="password" required autocomplete="current-password">
      @error('password')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
      @enderror
    </div>
    
    <div class="form-group d-flex align-items-center justify-content-between">
      <div class="form-check">
        <label class="form-check-label">
          <input type="checkbox" class="form-check-input"> Remember me </label>
      </div>
      @if (Route::has('password.request'))
          <a class="forgot-pass" href="{{ route('password.request') }}">
              {{ __('Forgot Your Password?') }}
          </a>
      @endif
    </div>

    <div class="text-center">
      <button type="submit" class="btn btn-primary btn-block enter-btn"> {{ ('Login') }}</button>
    </div>

    <div class="d-flex">
      <button class="btn btn-facebook mr-2 col">
        <i class="mdi mdi-facebook"></i> Facebook </button>
      <button class="btn btn-google col">
        <i class="mdi mdi-google-plus"></i> Google plus </button>
    </div>

    <p class="sign-up">Don't have an Account?<a href="{{ route ('register') }}"> {{ ('Register') }}</a></p>
  </form>
@endsection