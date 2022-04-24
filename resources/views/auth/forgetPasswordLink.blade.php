@extends('layouts.auth-template')

@section('title', 'Password reset')

@section('content')
    <script>
        function ViewPass()
        {
            var input = document.getElementById("password");
            var icon = document.getElementById("iconPassword");
            if(input.type === "password")
            {
                input.type = "text";
                icon.className = "fa fa-eye-slash fa-fw";
            }
            else{
                input.type = "password";
                icon.className = "fa fa-eye fa-fw";
            }
        }
        function ViewConfirmPass()
        {
            var input = document.getElementById("password-confirm");
            var icon = document.getElementById("iconConfirmPassword");
            if(input.type === "password")
            {
                input.type = "text";
                icon.className = "fa fa-eye-slash fa-fw";
            }
            else{
                input.type = "password";
                icon.className = "fa fa-eye fa-fw";
            }
        }
    </script>
    <div class="text-center">
        <h1 class="h4 text-gray-900 mb-4">KANCCI - Reset password</h1>
    </div>
    <form action="{{ route('reset.password.post') }}" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="form-group">
            <label for="email" class="text-dark">{{ __('E-Mail Address') }}</label>
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-at fa-fw" id="iconTitle"></i></span>
                </div>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            </div>
            @if ($errors->has('email'))
                <span class="text-danger">{{ $errors->first('email') }}</span>
            @endif
        </div>
        <div class="form-group">
            <label for="password" class="text-dark">{{ __('Password') }}</label>
            <div class="input-group mb-2">
                <input type="password" id="password" class="form-control" name="password" required autofocus>
                <div class="input-group-append">
                    <span class="input-group-text"><a onclick="ViewPass()" href="#"><i class="fa fa-eye fa-fw" id="iconPassword"></i></a></span>
                </div>
                @if ($errors->has('password'))
                    <span class="text-danger">{{ $errors->first('password') }}</span>
                @endif
            </div>
        </div>
        <div class="form-group">
            <label for="password-confirm" class="text-dark">Confirm Password</label>
            <div class="input-group mb-2">
                <input type="password" id="password-confirm" class="form-control" name="password_confirmation" required autofocus>
                <div class="input-group-append">
                    <span class="input-group-text"><a onclick="ViewConfirmPass()" href="#"><i class="fa fa-eye fa-fw" id="iconConfirmPassword"></i></a></span>
                </div>
                @if ($errors->has('password_confirmation'))
                    <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                @endif
            </div>
        </div>
        <button type="submit" class="btn btn-success btn-user btn-block">
            Reset password
        </button>
    </form>
@stop
