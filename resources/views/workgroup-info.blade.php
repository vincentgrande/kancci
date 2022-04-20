@extends('layouts.template')

@section('title', 'Workgroup Infos')
@section('actions')
    <li class="nav-item active">
        <a class="nav-link" href="{{route('workgroup', $workgroup[0]->id)}}">
            <i class="fas fa-arrow-left"></i>
            <span>Back to WorkGroup</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <li class="nav-item active" id="manageWorkgroup">
        <a class="nav-link" href="{{route('WorkgroupInfosGet', $workgroup[0]->id)}}"> <!-- TO DO : Open modal with workgroup settings-->
            <i class="fas fa-cog"></i>
            <span>Manage Informations</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
@endsection
@section('content')
    <div id="infos" class="justify-content-center mx-auto">
        <form class="form-group" action="{{route('WorkgroupInfoPost', ['id' => $workgroup[0]->id])}}" method="post">
            @csrf
            <div class="row">
                <label class="mx-auto" for="title">Titre</label>
            </div>
            <div class="input-group ml-2 mr-2 mb-2">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-ad fa-fw" id="iconTitle"></i></span>
                </div>
                <input class="form-control" type="text" id="title" name="title" placeholder="{{$workgroup[0]->title}}" required="required"/>
            </div>
            <input class="form-control m-2" type="submit" value="Update"/>
        </form>
        <div class="" style="border-top: 1px solid #8c8b8b;"></div>
        <form class="form-group mt-2" action="{{route('WorkgroupInfoPost', ['id' => $workgroup[0]->id])}}" method="post">
            @csrf
            <label for="background" class="justify-content-center mx-auto">Background</label>
            <img class="row img-profile mx-auto ml-4" src="/img/wallpaper/4.jpg" WIDTH="100" HEIGHT="100" alt="background"/>
            <label for="image" class="label-control ml-2">Choose file</label>
            <div class="hiddenradio">
                <label>
                    <input type="radio" name="back" value="1">
                    <img src="/img/wallpaper/1.jpg" height="100" width="100">
                </label>

                <label>
                    <input type="radio" name="back" value="2">
                    <img src="/img/wallpaper/2.jpg" height="100" width="100">
                </label>
                <label>
                    <input type="radio" name="back" value="3">
                    <img src="/img/wallpaper/3.jpg" height="100" width="100">
                </label>

                <label>
                    <input type="radio" name="back" value="4">
                    <img src="/img/wallpaper/4.jpg" height="100" width="100">
                </label>
                <label>
                    <input type="radio" name="back" value="5">
                    <img src="/img/wallpaper/5.jpg" height="100" width="100">
                </label>
                <label>
                    <input type="radio" name="back" value="6">
                    <img src="/img/wallpaper/6.jpg" height="100" width="100">
                </label>
                <label>
                    <input type="radio" name="back" value="7">
                    <img src="/img/wallpaper/7.jpg" height="100" width="100">
                </label>
            </div>
            <input type="submit" class="row form-control mt-1 ml-2" value="Change Background"/>
        </form>
    </div>
@endsection
