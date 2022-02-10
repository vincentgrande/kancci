@extends('layouts.auth-template')
 
@section('title', 'Register')
 
@section('content')
    <div class="text-center">
        <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
    </div>
    <form class="user">
        <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
                <input type="text" class="form-control form-control-user" id="exampleFirstName"
                    placeholder="First Name">
            </div>
            <div class="col-sm-6">
                <input type="text" class="form-control form-control-user" id="exampleLastName"
                    placeholder="Last Name">
            </div>
        </div>
        <div class="form-group">
            <input type="email" class="form-control form-control-user" id="exampleInputEmail"
                placeholder="Email Address">
        </div>
        <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
                <input type="password" class="form-control form-control-user"
                    id="exampleInputPassword" placeholder="Password">
            </div>
            <div class="col-sm-6">
                <input type="password" class="form-control form-control-user"
                    id="exampleRepeatPassword" placeholder="Repeat Password">
            </div>
        </div>
        <a href="{{route("login")}}" class="btn btn-success btn-user btn-block">
            Register Account
        </a>
    </form>
    <hr>
    <div class="text-center">
        <a class="small" href="{{route("forgot-password")}}">Forgot Password?</a>
    </div>
    <div class="text-center">
        <a class="small" href="{{route("login")}}">Already have an account? Login!</a>
    </div>
@stop