<?php
use Illuminate\Support\Facades\Auth;
?>
@extends('layouts.template')

@section('title', 'Profile Settings')
@section('actions')
    <li class="nav-item active">
        <a class="nav-link" id="addBoard" href="{{route('settingsProfileGet')}}">
            <i class="fas fa-user"></i>
            <span>Profile</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <li class="nav-item active">
        <a class="nav-link" href="{{route('settingsEmailGet')}}">
            <i class="fas fa-at"></i>
            <span>E-mail</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <li class="nav-item active">
        <a class="nav-link" href="{{route('settingsSecurityGet')}}">
            <i class="fas fa-lock"></i>
            <span>Security</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
@endsection
@section('content')
    <div class="container">
        @if (Session::has('message'))
            <div class="row justify-content-center w-auto">
                <div class="alert alert-success text-justify w-100" role="alert">
                    {{ Session::get('message') }}
                </div>
            </div>
        @endif
        @if (Session::has('error'))
            <div class="row justify-content-center w-auto">
                <div class="alert alert-danger text-justify w-100" role="alert">
                    {{ Session::get('error') }}
                </div>
            </div>
        @endif
        <div class="row justify-content-center mx-auto w-50">
            <form class="form-group" action="{{route('settingsEmailPost')}}" method="post">
                @csrf
                <label for="mail" class="label-control">E-mail :</label>
                <input type="email" id="mail" name="mail" class="form-control-" placeholder="<?php echo Auth::user()->email;?>"/>
                <input type="submit" value="Changer mon adresse"/>
            </form>
        </div>
    </div>
@endsection
