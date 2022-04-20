@extends('layouts.auth-template')
@section('title', 'Register')

@section('content')
    <div class="text-center">
        <h1 class="h4 text-gray-900 mb-4 mx-auto">Create an Account !</h1>
    </div>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <label for="name" class="text-dark">{{ __('Name') }}</label>
        <div class="form-group row">
            <div class="input-group col-sm-6 mb-3 mb-sm-0">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-user fa-fw" id="iconName"></i></span>
                </div>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                @error('name')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>

        </div>
        <div class="form-group row">
            <label for="email" class="text-dark mx-3">{{ __('E-Mail Address') }}</label>
            <div class="input-group col-sm-auto mb-3 mb-sm-0">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-at fa-fw" id="iconName"></i></span>
                </div>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                @error('email')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
                <label for="password" class="text-dark">{{ __('Password') }}</label>
                <div class="input-group mb-2">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                    <div class="input-group-append">
                        <span class="input-group-text"><a onclick="ViewPass()" href="#"><i class="fa fa-eye fa-fw" id="iconPassword"></i></a></span>
                    </div>
                    @if ($errors->has('confirmNewPassword'))
                        <span class="text-danger">{{ $errors->first('confirmNewPassword') }}</span>
                    @endif
                </div>
                @error('password')
                <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong></span>
            @enderror
            </div>
            <div class="col-sm-6 mb-3 mb-sm-0">
                <label for="password-confirm" class="text-dark">{{ __('Confirm Password') }}</label>
                <div class="input-group mb-2">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    <div class="input-group-append">
                        <span class="input-group-text"><a onclick="ViewConfirmPass()" href="#"><i class="fa fa-eye fa-fw" id="iconConfirmPassword"></i></a></span>
                    </div>
                    @if ($errors->has('confirmNewPassword'))
                        <span class="text-danger">{{ $errors->first('confirmNewPassword') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-sm-6 mt-2">
                {!! NoCaptcha::display() !!}
            </div>
        </div>

        <button type="submit" class="btn btn-success btn-user btn-block mt-2">
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
