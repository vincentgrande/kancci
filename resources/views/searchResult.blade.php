@extends('layouts.template')

@section('title', 'Home')

@section('actions')
    <li class="nav-item active">
        <a class="nav-link" id="addWorkgroup" href="#">
            <i class="fas fa-plus-square"></i>
            <span>Create workgroup</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
@endsection
@section('content')
    <div>
        <label class="bg-light" id="labelownerWorkgroups" for="ownerWorkgroups" style="margin-left: 15px;
                                 margin-top: -12px; position: absolute; border: 2px solid #f8f9fc;">Your Workgroups</label>
        <div class="row justify-content-center ml-1 mr-2 mb-3 border border-primary rounded" id="ownerWorkgroups">
        </div>
        <label class="bg-light" id="labelinvitedWorkgroups" for="invitedWorkgroups" style="margin-left: 15px;
                                 margin-top: -12px; position: absolute; border: 2px solid #f8f9fc;">Invited Workgroups</label>
        <div class="row justify-content-center ml-1 mr-2 mb-3 border border-primary rounded" id="invitedWorkgroups">
        </div>
        <label class="bg-light" id="labelownerKanbans" for="ownerKanbans" style="margin-left: 15px;
                                 margin-top: -12px; position: absolute; border: 2px solid #f8f9fc;">Your Kanbans</label>
        <div class="row justify-content-center ml-1 mr-2 mb-3 border border-primary rounded" id="ownerKanbans">
        </div>
        <label class="bg-light" id="labelinvitedKanbans" for="invitedKanbans" style="margin-left: 15px;
                                 margin-top: -12px; position: absolute; border: 2px solid #f8f9fc;">Invited Kanbans</label>
        <div class="row justify-content-center ml-1 mr-2 mb-3 border border-primary rounded" id="invitedKanbans">
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        /**
         * Action to do when the page is loaded
         */
        $(document).ready(function() {
            $('#ownerWorkgroups').hide(100);
            $('#invitedWorkgroups').hide(100);
            $('#labelownerWorkgroups').hide(100);
            $('#labelinvitedWorkgroups').hide(100);
            $('#ownerKanbans').hide(100);
            $('#invitedKanbans').hide(100);
            $('#labelownerKanbans').hide(100);
            $('#labelinvitedKanbans').hide(100);
            setResult();
        });
        /**
         * Initialize Data from Workgroups and Kanban after search
         */
        let setResult = function ()
        {
            let workgroups = {!! json_encode($workgroups) !!};
            let kanbans = {!! json_encode($kanbans) !!};
            workgroups.forEach(x => {
                if(x !== null) {
                    if (x.created_by !== {{\Illuminate\Support\Facades\Auth::user()->id}}) {
                        $('#invitedWorkgroups').append(`
                            <div class="mt-2">
                              <div class="card m-2" style="width: 20rem;">
                                <div class="card-body text-center">
                                    <img class="img-thumbnail mb-3 mx-auto" src="../img/` + x.logo + `" width="100" height="100"/>
                                  <h5 class="card-title">` + x.title + `</h5>
                                  <a href="/workgroup/` + x.id + `" class="btn btn-primary">Go to workgroup !</a>
                                </div>
                              </div>
                            </div>
                            `)
                        $('#invitedWorkgroups').show(100)
                        $('#labelinvitedWorkgroups').show(100)
                    } else {
                        $('#ownerWorkgroups').append(`
                            <div class="mt-2">
                              <div class="card m-2" style="width: 20rem;">
                                <div class="card-body text-center">
                                    <img class="img-thumbnail mb-3 mx-auto" src="../img/` + x.logo + `" width="100" height="100"/>
                                  <h5 class="card-title">` + x.title + `<i class="fas fa-crown text-warning"></i>
                                  </h5>
                                  <a href="/workgroup/` + x.id + `" class="btn btn-primary">Go to workgroup !</a>
                                </div>
                              </div>
                           </div>
                        `)
                        $('#ownerWorkgroups').show(100)
                        $('#labelownerWorkgroups').show(100)
                    }
                }
            });
            kanbans.forEach(x => {
                if(x !== null) {
                    if (x.created_by !== {{\Illuminate\Support\Facades\Auth::user()->id}}) {
                        $('#invitedKanbans').append(`
                            <div class="mt-2">
                              <div class="card m-2" style="width: 20rem;">
                                <div class="card-body text-center">
                                    <img class="img-thumbnail mb-3 mx-auto" src="../img` + x.background + `" width="200" height="200"/>
                                  <h5 class="card-title">` + x.title + `</h5>
                                  <a href="/kanban/` + x.id + `" class="btn btn-primary">Go to workgroup !</a>
                                </div>
                              </div>
                            </div>
                            `)
                        $('#invitedKanbans').show(100)
                        $('#labelinvitedKanbans').show(100)
                    } else {
                        $('#ownerKanbans').append(`
                            <div class="mt-2">
                              <div class="card m-2" style="width: 20rem;">
                                <div class="card-body text-center">
                                    <img class="img-thumbnail mb-3 mx-auto" src="../img` + x.background + `" width="200" height="200"/>
                                  <h5 class="card-title">` + x.title + `<i class="fas fa-crown text-warning"></i>
                                  </h5>
                                  <a href="/kanban/` + x.id + `" class="btn btn-primary">Go to workgroup !</a>
                                </div>
                              </div>
                           </div>
                        `)
                        $('#ownerKanbans').show(100)
                        $('#labelownerKanbans').show(100)
                    }
                }
            });
        }
    </script>
@endsection
