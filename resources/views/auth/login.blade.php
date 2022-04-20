@extends('layouts.auth-template')
@section('title', 'Login')

@section('content')

    <div class="text-center">
        <h1 class="h4 text-gray-900 mb-4">KANCCI - Login</h1>
    </div>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group justify-content-center w-auto">
            <label for="email" class="text-dark">{{ __('E-Mail Address') }}</label>
            <div class="input-group mb-3 mb-sm-0">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-at fa-fw" id="iconName"></i></span>
                </div>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="example@example.com" required="required" autocomplete="email" autofocus>
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label for="password" class="text-dark">{{ __('Password') }}</label>
            <div class="input-group mb-2">
                <input id="password" type="password" class="form-control" name="password" required autocomplete="password">
                <div class="input-group-append">
                    <span class="input-group-text"><a onclick="ViewPass()" href="#"><i class="fa fa-eye fa-fw" id="iconPassword"></i></a></span>
                </div>
                @error('password')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                @enderror
            </div>
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
<script type="text/javascript">

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
</script>
