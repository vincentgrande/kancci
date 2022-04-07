@extends('layouts.auth-template')
@section('title', 'Register')

@section('content')
    <div class="text-center">
        <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
    </div>
    <form method="POST" action="{{ route('register') }}">
        <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
                <label for="name" class="text-dark">{{ __('Name') }}</label>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                @error('name')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>

        </div>
        <div class="form-group">
            <label for="email" class="text-dark">{{ __('E-Mail Address') }}</label>

            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

            @error('email')
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
            @enderror
        </div>
        <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
                <label for="password" class="text-dark">{{ __('Password') }}</label>

                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                @error('password')
                <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong></span>
            @enderror
            </div>
            <div class="col-sm-6">
                <label for="password-confirm" class="text-dark">{{ __('Confirm Password') }}</label>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
            </div>
        </div>

        <button type="submit" class="btn btn-success btn-user btn-block">
            Register Account
        </button>
    </form>
    <hr>
    <div class="text-center">
        <a class="small" href="{{route("forget.password.get")}}">Forgot Password?</a>
    </div>
    <div class="text-center">
        <a class="small" href="{{route("login")}}">Already have an account? Login!</a>
    </div>


@endsection
