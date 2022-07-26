@extends ('layouts.auth')

@section ('content')
<h3 class="card-title text-left mb-3">Register</h3>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="form-group">
            <label>Username</label>
            <input type="text" class="form-control p_input @error ('username') is-invlaid @enderror" 
                name="username"
                value="{{old ('username') }}">
            @error ('username')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control p_input @error ('email') is-invalid @enderror"
                name="email"
                value="{{ old('email') }}">
            @error ('username')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control p_input @error ('password') is-invalid @enderror"
                name="password"
                value="">
            @error ('password')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password-confirm">{{ __('Confirm Password') }}</label>
            <input id="password-confirm" type="password" class="form-control p_input"
                name="password_confirmation" required autocomplete="new-password">
        </div>

        <div class="form-group d-flex align-items-center justify-content-between">
            <div class="form-check">
                <label class="form-check-label">
                <input type="checkbox" class="form-check-input"> Remember me </label>
            </div>
            <a href="#" class="forgot-pass">Forgot password</a>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary btn-block enter-btn">{{ ('Register') }}</button>
        </div>

        <div class="d-flex">
            <button class="btn btn-facebook col mr-2">
                <i class="mdi mdi-facebook"></i> Facebook </button>
            <button class="btn btn-google col">
                <i class="mdi mdi-google-plus"></i> Google plus </button>
        </div>
        <p class="sign-up text-center">Already have an Account?<a href="#"> {{ ('Login') }}</a></p>
        <p class="terms">By creating an account you are accepting our<a href="#"> Terms & Conditions</a></p>
    </form>
@endsection