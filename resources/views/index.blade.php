@extends('layouts.template')
<?php

    ?>

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
    <div>
        <label class="bg-light" id="labelownerWorkgroups" for="ownerWorkgroups" style="margin-left: 15px;
                                 margin-top: -12px; position: absolute; border: 2px solid #f8f9fc;">Your Workgroups</label>
        <div class="row justify-content-center ml-1 mr-2 mb-3 border border-primary rounded" id="ownerWorkgroups">

        </div>
        <label class="bg-light" id="labelinvitedWorkgroups" for="invitedWorkgroups" style="margin-left: 15px;
                                 margin-top: -12px; position: absolute; border: 2px solid #f8f9fc;">Invited Workgroups</label>
        <div class="row justify-content-center ml-1 mr-2 mb-3 border border-primary rounded" id="invitedWorkgroups">

        </div>
    </div>
    <div id="modal-container"></div>
@stop

@section('scripts')
    <script>
        /**
         * function to add a new kanban
         */
        let newWorkgroup = function(title){
            $.ajax({
                url: "{{ route('addWorkgroup') }}",
                method: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "title" : title,
                },
                success: function(result){
                    $('#edit').modal('hide');
                    console.log(result)
                    getWorkGroup()
                }});
        }
        /**
         * Return Modal container visible
         * @type {HTMLElement}
         */
        let addWorkgroup = document.getElementById("addWorkgroup");
        addWorkgroup.addEventListener("click", function() {
            $('#modal-container').append (`
                            <div class="modal edit-modal" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Create a new workgroup !</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#edit').modal('hide'); ">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <label for="title" class="label-control">Title :</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-tag fa-fw" id="iconTitle"></i></span>
                                            </div>
                                            <input id="title" type="text" class="form-control" name="title">
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="$('#edit').modal('hide'); $('.edit-modal').remove();">Close</button>
                                    <button type="button" class="btn btn-success" onclick="newWorkgroup($('#title').val())">Create</button>
                                </div>
                            </div>
                        </div>
                    </div>
            `);
            $('#edit').modal('show');
        });
        /**
         * On Page Ready
         */
        $(document).ready(function() {
            getWorkGroup()
            $(document).on('hide.bs.modal','.edit-modal', function () {
                $('.edit-modal').remove(); // Remove edit board modal on close event
            });
        });
        /**
         *  Get all Workgroups (Own and Invited)
         */
        let getWorkGroup = function() {
            let invitedWorkgroups = $('#invitedWorkgroups');
            let ownerWorkgroups = $('#ownerWorkgroups');
            let labelinvitedWorkgroups =  $('#labelinvitedWorkgroups');
            let labelownerWorkgroups = $('#labelownerWorkgroups');
            invitedWorkgroups.empty()
            ownerWorkgroups.empty()
            invitedWorkgroups.hide(100)
            labelinvitedWorkgroups.hide(100)
            ownerWorkgroups.hide(100)
            labelownerWorkgroups.hide(100)
            $.ajax({
                url: "{{ route('getWorkgroup') }}",
                method: 'get',
                data: {
                },
                success: function(result){
                    result.forEach(x => {
                        if(x.workgroup !== null) {
                            if (x.workgroup.created_by !== x.user_id) {
                                invitedWorkgroups.append(`
                            <div class="mt-2">
                              <div class="card m-2" style="width: 20rem;">
                                <div class="card-body text-center">
                                    <img class="img-thumbnail mb-3 mx-auto" src="../img/` + x.workgroup.logo + `" width="100" height="100"/>
                                  <h5 class="card-title">` + x.workgroup.title + `</h5>
                                  <a href="/workgroup/` + x.workgroup.id + `" class="btn btn-primary">Go to workgroup !</a>
                                  <a id="leaveWorkgroup" href="#" class="btn btn-danger mt-2" onclick="ShowModal(`+ x.workgroup.id +`)">Leave the Workgroup</a>
                                </div>
                              </div>
                            </div>
                            `)
                                invitedWorkgroups.show(100)
                                labelinvitedWorkgroups.show(100)
                            } else {
                                ownerWorkgroups.append(`
                            <div class="mt-2">
                              <div class="card m-2" style="width: 20rem;">
                                <div class="card-body text-center">
                                    <img class="img-thumbnail mb-3 mx-auto" src="../img/` + x.workgroup.logo + `" width="100" height="100"/>
                                  <h5 class="card-title">` + x.workgroup.title + `<i class="fas fa-crown text-warning"></i>
                                  </h5>
                                  <a href="/workgroup/` + x.workgroup.id + `" class="btn btn-primary">Go to workgroup !</a>
                                </div>
                              </div>
                           </div>
                        `)
                                ownerWorkgroups.show(100)
                                labelownerWorkgroups.show(100)
                            }
                        }
                    })
                }});
        }
        function ShowModal(workgroup_id)
        {
                $('#modal-container').append(`
                            <div class="modal edit-modal" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Leave a Workgroup !</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#edit').modal('hide'); $('.edit-modal').remove();">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <h5>Warning you will quit this Workgroup !</h5>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-success" data-dismiss="modal" onclick="$('#edit').modal('hide'); $('.edit-modal').remove();">Close</button>
                                    <button type="button" class="btn btn-danger" onclick="ModalShowLeaving(`+ workgroup_id +`)">Leave</button>
                                </div>
                            </div>
                        </div>
                    </div>
            `);
            $('#edit').modal('show');
        }
        function ModalShowLeaving(workgroup_id)
        {
            $.ajax({
                url: "{{ route('leaveWorkgroup') }}",
                method: 'get',
                data: {
                    'workgroup_id' : workgroup_id
                },
                success: function(result){
                    if(result === "true")
                    {
                        $('#edit').modal('hide');
                        $('.edit-modal').remove();
                        getWorkGroup();
                    }
                    else
                    {
                        $('#edit').modal('hide');
                        $('.edit-modal').remove();
                        alert(result);
                    }
                }
            });
        }
    </script>

@endsection
