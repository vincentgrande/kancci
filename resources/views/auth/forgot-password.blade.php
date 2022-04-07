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
        <div class="form-group">
            <input type="email" class="form-control form-control-user" id="email_address" name="email" aria-describedby="emailHelp" placeholder="Enter Email Address...">
            @if ($errors->has('email'))
                <span class="text-danger">{{ $errors->first('email') }}</span>
            @endif
        </div>
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