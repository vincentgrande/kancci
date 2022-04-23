@extends('layouts.template')

@section('title', 'Home')

@section('actions')
    <li class="nav-item active">
        <a class="nav-link" id="addKanban" href="#">
            <i class="fas fa-plus-square"></i>
            <span>Create kanban</span></a>
    </li>
    <!-- Divider -->
    <?php
    use Illuminate\Support\Facades\Auth;
    if($workgroup_users[0]->workgroup->created_by == Auth::user()->id)
    {?>
    <hr class="sidebar-divider">
    <li class="nav-item active" id="manageWorkgroup">
        <a class="nav-link" href="{{route('WorkgroupInfosGet', $workgroup->id)}}">
            <i class="fas fa-cog"></i>
            <span>Manage workgroup</span></a>
    </li>
    <?php
        }
    ?>
    <!-- Divider -->
    <hr class="sidebar-divider">
@endsection
@section('scripts')
    <script>
        /**
         * function to add a new kanban
         */
            let newKanban = function (title, background) {
                $.ajax({
                    url: "{{ route('addKanban') }}",
                    method: 'post',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "workgroup_id": {{$workgroup_users[0]->workgroup->id}},
                        "title": title,
                        "background": background
                    },
                    success: function (result) {
                        $('#edit').modal('hide');
                        console.log(result)
                        getKanban()
                    }
                });
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
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-tag fa-fw" id="iconTitle"></i></span>
                                            </div>
                                            <input class="form-control" type="text" id="title" name="title" placeholder="Your title...">
                                        </div>
                                    <label for="back" class="justify-content-center mx-auto">Background :</label>
                                    <div class="hiddenradio">
                                        <label>
                                            <input type="radio" id="background" name="background" value="1">
                                            <img src="/img/wallpaper/1.jpg" height="100" width="100">
                                        </label>

                                        <label>
                                            <input type="radio" id="background" name="background" value="2">
                                            <img src="/img/wallpaper/2.jpg" height="100" width="100">
                                        </label>
                                        <label>
                                            <input type="radio" id="background" name="background" value="3">
                                            <img src="/img/wallpaper/3.jpg" height="100" width="100">
                                        </label>

                                        <label>
                                            <input type="radio" id="background" name="background" value="4">
                                            <img src="/img/wallpaper/4.jpg" height="100" width="100">
                                        </label>
                                        <label>
                                            <input type="radio" id="background" name="background" value="5">
                                            <img src="/img/wallpaper/5.jpg" height="100" width="100">
                                        </label>
                                        <label>
                                            <input type="radio" id="background" name="background" value="6">
                                            <img src="/img/wallpaper/6.jpg" height="100" width="100">
                                        </label>
                                        <label>
                                            <input type="radio" id="background" name="background" value="7">
                                            <img src="/img/wallpaper/7.jpg" height="100" width="100">
                                        </label>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="$('#edit').modal('hide');">Close</button>
                                    <button type="button" class="btn btn-success" onclick="newKanban($('#title').val(), $('#background').val())">Save changes</button>
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
                    "workgroup_id" :  {{$workgroup_users[0]->workgroup->id}},
                },
                success: function(result){
                    result.forEach(x => {
                        if(x.created_by === {{\Illuminate\Support\Facades\Auth::user()->id}}) {
                            $('.kanbans').append(`
                            <div class="">
                                <div class="card m-2" style="width: 20rem;">
                                    <img class="card-img-top" src="../img` + x.background + `" alt="Card image cap" width="200" height="200">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">` + x.title + `
                                            <i class="fas fa-crown text-warning" id="iconCrown"></i>
                                        </h5>
                                        <a href="/kanban/` + x.id + `" class="btn btn-primary">Go to kanban !</a>
                                    </div>
                                </div>
                            </div>
                        `);
                        }
                        else {
                            $('.kanbans').append(`
                            <div class="">
                                <div class="card m-2" style="width: 20rem;">
                                    <img class="card-img-top" src="../img` + x.background + `" alt="Card image cap" width="200" height="200">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">` + x.title + `</h5>
                                        <a href="/kanban/` + x.id + `" class="btn btn-primary">Go to kanban !</a>
                                    </div>
                                </div>
                            </div>
                            `);
                        }
                    })
                }});
        }
    </script>
@endsection

@section('content')

   <div class="row kanbans mb-3 justify-content-center mx-auto w-auto col-auto"></div>
   <div id="modal-container"></div>
@endsection
