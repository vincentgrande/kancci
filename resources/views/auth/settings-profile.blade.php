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
            <div class="container justify-content-center mx-auto w-auto">
                <div class="row justify-content-cente mx-auto w-auto col-auto">
                    <img class="img-profile rounded-circle mb-3 mx-auto" src="../img/<?php echo Auth::user()->picture;?>" height="100px" width="100px"/>
                </div>
                <div class="row">
                    <form class="form-group" action="{{route('settingsProfilePost')}}" method="post" enctype="multipart/form-data">
                        @csrf
                            <label for="image" class="label-control">Choose file</label>
                            <input type="file" class="form-control" id="image" name="image"/>
                        <input type="submit" class="form-control" value="Upload"/>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
