@extends('layouts.template')

@section('title', 'Home')

@section('actions')
    <li class="nav-item active">
        <a class="nav-link" id="addKanban">
            <i class="fas fa-plus-square"></i>
            <span>Create kanban</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <li class="nav-item active" id="manageWorkgroup">
        <a class="nav-link"> <!-- TO DO : Open modal with workgroup settings-->
            <i class="fas fa-cog"></i>
            <span>Manage workgroup</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
@endsection

@section('content')

   <div class="row kanbans"></div>
   <div id="modal-container"></div>

@stop
@section('scripts')
    <script>
        /**
         * function to add a new kanban
         */
        let newKanban = function(title){
            $.ajax({
                url: "{{ route('addKanban') }}",
                method: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "workgroup_id" :  {{$workgroup->workgroup_id}},
                    "title" : title,
                },
                success: function(result){
                    $('#edit').modal('hide');
                    console.log(result)
                    getKanban()
                }});
        }
        let addKanban = document.getElementById("addKanban");
        addKanban.addEventListener("click", function() {
            $('#modal-container').append (`
                            <div class="modal edit-modal" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Create a new kanban !</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#edit').modal('hide'); ">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <label for="title">Title:</label>
                                        <input type="text" id="title" name="title"><br>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="$('#edit').modal('hide');">Close</button>
                                        <button type="button" class="btn btn-success" onclick="newKanban($('#title').val())">Save changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>`);
            $('#edit').modal('show');
        });
        let manageWorkgroup = document.getElementById("manageWorkgroup");
        manageWorkgroup.addEventListener("click", function() {
            $('#modal-container').append (`
                            <div class="modal edit-modal" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Manage workgroup !</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#edit').modal('hide'); ">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <label for="title">Title : </label>
                                        <input type="text" id="title" name="title" value="{{ $workgroup->workgroup->title }}"><br>
                                         <hr class="sidebar-divider">
                                        <label for="invite">Invite : </label>
                                        <input type="text" id="invite" name="invite" placeholder="Partner email"><br>
                                    @foreach($workgroup_users as $user)
                                    <hr class="sidebar-divider">
                                    <div class="row">
                                      <div class="col-md-7 col-sm-7">
                                        <h5><a href="#" class="profile-link">{{$user->user->name}}</a></h5>
                                            <p>{{$user->user->email}}</p>
                                          </div>
                                          <div class="col-md-3 col-sm-3">
                                            <button class="btn btn-danger pull-right">Remove</button>
                                          </div>
                                          </div>
                                    @endforeach
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="$('#edit').modal('hide');">Close</button>
                                        <button type="button" class="btn btn-success" onclick="newKanban($('#title').val())">Save changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>`);
            $('#edit').modal('show');
        });
        $(document).ready(function() {
            getKanban()
            $(document).on('hide.bs.modal','.edit-modal', function () {
                $('.edit-modal').remove(); // Remove edit board modal on close event
            });
        });
        let getKanban = function(){
            $('.kanbans').empty()
            $.ajax({
                url: "{{ route('getKanban') }}",
                method: 'get',
                data: {
                    "workgroup_id" :  {{$workgroup->workgroup_id}},
                },
                success: function(result){
                    result.forEach(x => {
                        $('.kanbans').append(`
                            <div class="col-sm-6">
                                <div class="card m-2" style="width: 20rem;">
                                    <div class="card-body text-center">
                                        <h5 class="card-title"> `+x.title+`</h5>
                                        <a href="/kanban/`+x.id+`" class="btn btn-primary">Go to kanban !</a>
                                    </div>
                                </div>
                            </div>
                        `)
                    })
                }});
        }
    </script>

@endsection
