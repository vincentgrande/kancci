@extends('layouts.auth-template')
 
@section('title', 'Password reset')
 
@section('content')
    <div class="text-center">
        <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>
    </div>
    <form class="user">
        <div class="form-group">
            <input type="email" class="form-control form-control-user"
                id="exampleInputEmail" aria-describedby="emailHelp"
                placeholder="Enter Email Address...">
        </div>
        <a href="{{route("login")}}" class="btn btn-primary btn-user btn-block">
            Reset Password
        </a>
    </form>
    <hr>
    <div class="text-center">
        <a class="small" href="{{route("register")}}">Create an Account!</a>
    </div>
    <div class="text-center">
        <a class="small" href="{{route("login")}}">Already have an account? Login!</a>
    </div>
@stop