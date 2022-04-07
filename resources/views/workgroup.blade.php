@extends('layouts.template')

@section('title', 'Home')

@section('actions')
    <li class="nav-item active">
        <a class="nav-link" id="addWorkspace">
            <i class="fas fa-plus-square"></i>
            <span>Create kanban</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">

@endsection

@section('content')
   <!--{{ $workgroup }}
   {{ $kanbans }}-->
   <div class="row">
    @foreach ($kanbans as $kanban)
    <div class="col-sm-6">
       <div class="card m-2" style="width: 20rem;">
         <div class="card-body text-center">
           <h5 class="card-title"> {{ $kanban->title }}</h5>
           <a href="{{ route('kanban',$kanban->id) }}" class="btn btn-primary">Go to kanban !</a>
         </div>
       </div>
    </div>
    @endforeach
  </div>
@stop

