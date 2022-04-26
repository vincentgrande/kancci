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
        function actuValRadio(number)
        {
            let rad1 = document.getElementById('background1');
            let rad2 = document.getElementById('background2');
            let rad3 = document.getElementById('background3');
            let rad4 = document.getElementById('background4');
            let rad5 = document.getElementById('background5');
            let rad6 = document.getElementById('background6');
            let rad7 = document.getElementById('background7');
            let inputValue = document.getElementById('backId');
            if(number !== 1)
            {
                rad1.checked = false;
            }
            else {
                rad1.checked = true;
                inputValue.value = rad1.value;
            }
            if(number !== 2)
            {
                rad2.checked = false;
            }
            else {
                rad2.checked = true;
                inputValue.value = rad2.value;
            }
            if(number !== 3)
            {
                rad3.checked = false;
            }
            else {
                rad3.checked = true;
                inputValue.value = rad3.value;
            }
            if(number !== 4)
            {
                rad4.checked = false;
            }
            else {
                rad4.checked = true;
                inputValue.value = rad4.value;
            }
            if(number !== 5)
            {
                rad5.checked = false;
            }
            else {
                rad5.checked = true;
                inputValue.value = rad5.value;
            }
            if(number !== 6)
            {
                rad6.checked = false;
            }
            else {
                rad6.checked = true;
                inputValue.value = rad6.value;
            }
            if(number !== 7)
            {
                rad7.checked = false;
            }
            else {
                rad7.checked = true;
                inputValue.value = rad7.value;
            }

        }
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
                                            <input type="radio" id="background1" name="background1" value="1" onclick="actuValRadio(1)">
                                            <img src="/img/wallpaper/1.jpg" height="100" width="100">
                                        </label>

                                        <label>
                                            <input type="radio" id="background2" name="background2" value="2" onclick="actuValRadio(2)">
                                            <img src="/img/wallpaper/2.jpg" height="100" width="100">
                                        </label>
                                        <label>
                                            <input type="radio" id="background3" name="background3" value="3" onclick="actuValRadio(3)">
                                            <img src="/img/wallpaper/3.jpg" height="100" width="100">
                                        </label>

                                        <label>
                                            <input type="radio" id="background4" name="background4" value="4" onclick="actuValRadio(4)">
                                            <img src="/img/wallpaper/4.jpg" height="100" width="100">
                                        </label>
                                        <label>
                                            <input type="radio" id="background5" name="background5" value="5" onclick="actuValRadio(5)">
                                            <img src="/img/wallpaper/5.jpg" height="100" width="100">
                                        </label>
                                        <label>
                                            <input type="radio" id="background6" name="background6" value="6" onclick="actuValRadio(6)">
                                            <img src="/img/wallpaper/6.jpg" height="100" width="100">
                                        </label>
                                        <label>
                                            <input type="radio" id="background7" name="background7" value="7" onclick="actuValRadio(7)">
                                            <img src="/img/wallpaper/7.jpg" height="100" width="100">
                                        </label>
                                        <input type="hidden" id="backId" name="backId" value="1"/>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="$('#edit').modal('hide');">Close</button>
                                    <button type="button" class="btn btn-success" onclick="newKanban($('#title').val(), $('#backId').val())">Save changes</button>
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
                                    <img class="card-img-top" src="../img` + x.background + `" alt="Background" width="200" height="200">
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
                                    <img class="card-img-top" src="../img` + x.background + `" alt="Background" width="200" height="200">
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
   <div class="row kanbans mb-3 justify-content-center mx-auto w-auto col-auto"></div>
   <div id="modal-container"></div>
@endsection
