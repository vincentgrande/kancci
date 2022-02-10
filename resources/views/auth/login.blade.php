@extends('layouts.auth-template')
 
@section('title', 'Login')
 
@section('content')
    <div class="text-center">
        <h1 class="h4 text-gray-900 mb-4">KANCCI - Login</h1>
    </div>
    <form class="user">
        <div class="form-group">
            <input type="email" class="form-control form-control-user text-dark"
                id="exampleInputEmail" aria-describedby="emailHelp"
                placeholder="Enter Email Address...">
        </div>
        <div class="form-group">
            <input type="password" class="form-control form-control-user text-dark"
                id="exampleInputPassword" placeholder="Password">
        </div>
        <div class="form-group">
            <div class="custom-control custom-checkbox small">
                <input type="checkbox" class="custom-control-input" id="customCheck">
                <label class="custom-control-label text-dark" for="customCheck">Remember
                    Me</label>
            </div>
        </div>
        <a href="{{route("index")}}" class="btn btn-success btn-user btn-block">
            Login
        </a>
    </form>
    <hr>
    <div class="text-center">
        <a class="small" href="{{route("forgot-password")}}">Forgot Password?</a>
    </div>
    <div class="text-center">
        <a class="small" href="{{route("register")}}">Create an Account!</a>
    </div>
@stop