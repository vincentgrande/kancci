@extends('layouts.template')

@section('title', 'Home')

@section('actions')
    <li class="nav-item active">
        <a class="nav-link" id="addWorkgroup">
            <i class="fas fa-cog"></i>
            <span>Create workgroup</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">

@endsection

@section('content')
    <div>
        <label id="labelownerWorkgroups" for="ownerWorkgroups" style="margin-left: 15px;
                                 margin-top: -12px; position: absolute;
                                 background-color: #f8f9fc; border: 2px solid #f8f9fc;">Your Workgroups</label>
        <div class="row justify-content-center ml-1 mr-2 mb-3 border border-primary rounded" id="ownerWorkgroups">

        </div>
        <label id="labelinvitedWorkgroups" for="invitedWorkgroups" style="margin-left: 15px;
                                 margin-top: -12px; position: absolute;
                                 background-color: #f8f9fc; border: 2px solid #f8f9fc;">Invited Workgroups</label>
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
        var addWorkgroup = document.getElementById("addWorkgroup");
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
                                    <button type="button" class="btn btn-success" onclick="newWorkgroup($('#title').val())">Create</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="$('#edit').modal('hide');">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
`);
            $('#edit').modal('show');
        });
        $(document).ready(function() {
            $('#ownerWorkgroups').hide(100)
            $('#invitedWorkgroups').hide(100)
            $('#labelownerWorkgroups').hide(100)
            $('#labelinvitedWorkgroups').hide(100)
            getWorkGroup()
            $(document).on('hide.bs.modal','.edit-modal', function () {
                $('.edit-modal').remove(); // Remove edit board modal on close event
            });
        });
        let getWorkGroup = function() {
            $.ajax({
                url: "{{ route('getWorkgroup') }}",
                method: 'get',
                data: {
                },
                success: function(result){
                    result.forEach(x => {
                        if(x.workgroup.created_by !== x.user_id) {
                            $('#invitedWorkgroups').empty()
                            $('#invitedWorkgroups').append(`
                            <div class="mt-2">
                              <div class="card m-2" style="width: 20rem;">
                                <div class="card-body text-center">
                                    <img class="img-thumbnail mb-3 mx-auto" src="../img/` + x.workgroup.logo + `" width="100" height="100"/>
                                  <h5 class="card-title">` + x.workgroup.title + `</h5>
                                  <a href="/workgroup/` + x.workgroup.id + `" class="btn btn-primary">Go to workgroup !</a>
                                </div>
                              </div>
                            </div>
                            `)
                            $('#invitedWorkgroups').show(100)
                            $('#labelinvitedWorkgroups').show(100)
                        }
                        else
                        {
                            $('#ownerWorkgroups').empty()
                            $('#ownerWorkgroups').append(`
                            <div class="mt-2">
                              <div class="card m-2" style="width: 20rem;">
                                <div class="card-body text-center">
                                    <img class="img-thumbnail mb-3 mx-auto" src="../img/`+ x.workgroup.logo+`" width="100" height="100"/>
                                  <h5 class="card-title">`+ x.workgroup.title+`<i class="fas fa-crown text-warning"></i>
                                  </h5>
                                  <a href="/workgroup/`+x.workgroup.id+`" class="btn btn-primary">Go to workgroup !</a>
                                </div>
                              </div>
                           </div>
                        `)
                            $('#ownerWorkgroups').show(100)
                            $('#labelownerWorkgroups').show(100)
                        }
                    })
                }});
        }
    </script>

@endsection
