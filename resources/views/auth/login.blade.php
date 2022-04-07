@extends('layouts.auth-template')
@section('title', 'Login')

@section('content')

    <div class="text-center">
        <h1 class="h4 text-gray-900 mb-4">KANCCI - Login</h1>
    </div>
    <form method="POST" action="{{ route('login') }}">
        <div class="form-group">
            <label for="email" class="text-dark">{{ __('E-Mail Address') }}</label>

            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

            @error('email')
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="password" class="text-dark">{{ __('Password') }}</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

            @error('password')
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
            @enderror
        </div>
        <div class="form-group">
            <div class="custom-control custom-checkbox small">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                <label class="form-check-label text-dark" for="remember">
                    {{ __('Remember Me') }}
                </label>
            </div>
        </div>
        <button type="submit" class="btn btn-success btn-user btn-block">
            Login
        </button>
    </form>
    <hr>
    <div class="text-center">
        <a class="small" href="{{route("forget.password.get")}}">Forgot Password?</a>
    </div>
    <div class="text-center">
        <a class="small" href="{{route("register")}}">Create an Account!</a>
    </div>


@endsection
