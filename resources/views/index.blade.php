@extends('layouts.template')

@section('title', 'Home')

@section('actions')
    <li class="nav-item active">
        <a class="nav-link" id="addWorkspace">
            <i class="fas fa-plus-square"></i>
            <span>Create workgroup</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">

@endsection

@section('content')
<!-- {{ $workgroups }}
-->   
<div class="row">
   @foreach ($workgroups as $workgroup)
   <div class="col-sm-6">
      <div class="card m-2" style="width: 20rem;">
        <div class="card-body text-center">
          <h5 class="card-title"> {{ $workgroup->workgroup->title }}
            @if ( $workgroup->workgroup->created_by == $workgroup->user_id)
               <i class="fas fa-crown text-warning"></i>           
            @endif
         </h5>
          <a href="{{ route('workgroup',$workgroup->workgroup->id) }}" class="btn btn-primary">Go to workgroup !</a>
        </div>
      </div>
   </div>
   @endforeach
 </div>
@stop

