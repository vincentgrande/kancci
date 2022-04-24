@extends('layouts.template')

@section('title', 'Security Settings')
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
    <script type="text/javascript">
        function ViewActualPass()
        {
            var input = document.getElementById("actualPassword");
            var icon = document.getElementById("iconactualPassword");
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
        function ViewNewPass()
        {
            var input = document.getElementById("newPassword");
            var icon = document.getElementById("iconnewPassword");
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
            var input = document.getElementById("confirmNewPassword");
            var icon = document.getElementById("iconconfirmNewPassword");
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
        <!-- Section Formulaire de Changement de Mot de Passe -->
        <div class="row justify-content-center mx-auto w-50" aria-label="Mot de passe">
            <div class="container-fluid mx-auto">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form class="form-group" action="{{route('settingsSecurityPost')}}" method="post">
                            @csrf
                            <label class="label-control" for="actualPassword">Mot de passe actuel :</label>
                            <div class="input-group mb-2">
                                    <input class="form-control" type="password" id="actualPassword" name="actualPassword" placeholder="Your actual password..." required="required"/>
                                <div class="input-group-append">
                                    <span class="input-group-text"><a onclick="ViewActualPass()" href="#"><i class="fa fa-eye fa-fw" id="iconactualPassword"></i></a></span>
                                </div>
                                @if ($errors->has('actualPassword'))
                                    <span class="text-danger">{{ $errors->first('actualPassword') }}</span>
                                @endif
                            </div>
                            <label class="label-control" for="newPassword">Nouveau Mot de Passe :</label>
                            <div class="input-group mb-2">
                                <input class="form-control" type="password" id="newPassword" name="newPassword" placeholder="Your new password..." required="required"/>
                                <div class="input-group-append">
                                    <span class="input-group-text"><a onclick="ViewNewPass()" href="#"><i class="fa fa-eye fa-fw" id="iconnewPassword"></i></a></span>
                                </div>
                                @if ($errors->has('newPassword'))
                                    <span class="text-danger">{{ $errors->first('newPassword') }}</span>
                                @endif
                            </div>
                            <label class="label-control" for="confirmNewPassword">Confirmer le Mot de Passe :</label>
                            <div class="input-group mb-2">
                                <input class="form-control" type="password" id="confirmNewPassword" name="confirmNewPassword" placeholder="Confirm your new password..." required="required"/>
                                <div class="input-group-append">
                                    <span class="input-group-text"><a onclick="ViewConfirmPass()" href="#"><i class="fa fa-eye fa-fw" id="iconconfirmNewPassword"></i></a></span>
                                </div>
                                @if ($errors->has('confirmNewPassword'))
                                    <span class="text-danger">{{ $errors->first('confirmNewPassword') }}</span>
                                @endif
                            </div>
                            <input class="form-control" type="submit" value="Changer le mot de passe"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Section -->
@endsection
