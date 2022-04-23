@extends('layouts.auth-template')

@section('title', 'Password reset')

@section('content')
    <div class="text-center">
        <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>
    </div>
    @if (Session::has('message'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('message') }}
        </div>
    @endif
    <form action="{{ route('forget.password.post') }}" method="POST">
        @csrf
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-at fa-fw" id="iconTitle"></i></span>
            </div>
            <input type="email" class="form-control form-control-user" id="email_address" name="email" aria-describedby="emailHelp" placeholder="Enter Email Address...">
        </div>
            @if ($errors->has('email'))
                <span class="text-danger">{{ $errors->first('email') }}</span>
            @endif
        <button type="submit" class="btn btn-primary btn-user btn-block">
            Reset Password
        </button>
    </form>
    <hr>
    <div class="text-center">
        <a class="small" href="{{route("register")}}">Create an Account!</a>
    </div>
    <div class="text-center">
        <a class="small" href="{{route("login")}}">Already have an account? Login!</a>
    </div>
@stop
