@extends('layouts.auth-template')
 
@section('title', 'Password reset')
 
@section('content')

    <div class="text-center">
        <h1 class="h4 text-gray-900 mb-4">KANCCI - Reset password</h1>
    </div>
    <form action="{{ route('reset.password.post') }}" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="form-group">
            <label for="email" class="text-dark">{{ __('E-Mail Address') }}</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            @if ($errors->has('email'))
                <span class="text-danger">{{ $errors->first('email') }}</span>
            @endif
        </div>
        <div class="form-group">
            <label for="password" class="text-dark">{{ __('Password') }}</label>
            <input type="password" id="password" class="form-control" name="password" required autofocus>
            @if ($errors->has('password'))
                <span class="text-danger">{{ $errors->first('password') }}</span>
            @endif
        </div>
        <div class="form-group">
            <label for="password-confirm" class="text-dark">Confirm Password</label>
            <input type="password" id="password-confirm" class="form-control" name="password_confirmation" required autofocus>
            @if ($errors->has('password_confirmation'))
                <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
            @endif
        </div>
        <button type="submit" class="btn btn-success btn-user btn-block">
            Reset password
        </button>
    </form>

@stop