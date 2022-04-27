@extends('layouts.template')

@section('title', 'Kanban')

@section('actions')
    <li class="nav-item active">
        <a class="nav-link" href="javascript:history.back(1);">
            <i class="fas fa-arrow-left"></i>
            <span>Back</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <li class="nav-item active">
        <a class="nav-link" id="addBoard" href="#">
            <i class="fas fa-plus-square"></i>
            <span>Add board</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <li class="nav-item active">
        <a class="nav-link" id="manageKanban" href="#"> <!-- TO DO : Open modal with kanban settings-->
            <i class="fas fa-cog"></i>
            <span>Manage kanban</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <li class="nav-item active">
        <a class="nav-link" @if(!isset($visibility)) href="{{ route('archived', ['id' => $kanban]) }}" @endif> <!-- TO DO : Open modal with kanban settings-->
            <i class="fas fa-archive"></i>
            <span>Archived items</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
@endsection

@section('content')

    <style>
        .kanban-container {
            width : max-content !important;
        }
        .border-4 {
            border-width:4px !important;
        }
    </style>
    <div id="myKanban" style="overflow: auto;" class="mb-3"></div>
    <div id="modal-container"></div>

@stop
@section('scripts')

    <script>
        @if(!isset($visibility))
        /**
         * Create and open manage kanban modal
         */
        var manageKanban = document.getElementById("manageKanban");
        manageKanban.addEventListener("click", function() {
            $.ajax({
                url: "{{ route('kanbanInfos') }}",
                method: 'get',
                data: {
                    id: {{ $kanban }}
                },
                success: function(result){
                    console.log(result)
                    $('#modal-container').append (`
                            <div class="modal manage-modal" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Manage kanban !</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#edit').modal('hide'); ">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                       <input id="id" type="text" class="form-control" name="id" value="`+result.kanban.id+`" hidden>
                                        <label for="title" class="label-control">Title :</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-tag fa-fw" id="iconTitle"></i></span>
                                            </div>
                                            <input id="title" type="text" class="form-control" name="title" value="`+result.kanban.title+`">
                                        </div>
 <hr class="sidebar-divider">
<label for="kanbanlabels">Labels :</label>
 <div class="mb-2" id="kanbanlabels">
 </div>
<label for="label_title">New label :</label>
<input class="form-control mb-2" type="text" id="label_title" name="label_title" placeholder="Label title" value="">
<label for="label_color">Color :</label>
<input class="form-control mb-2" type="color" id="label_color" name="label_color">
<button type="button" class="btn btn-outline-success mb-2" onclick="addLabel()">Add</button>
<select class="custom-select mb-2"  id="deletelabel" name="deletelabel" aria-label="Delete label">
  <option selected>Choose a label to delete it</option>
</select>
<button type="button" class="btn btn-outline-danger mb-2" onclick="deleteLabel()">Delete label</button>

 <hr class="sidebar-divider">
 <label for="visibility" class="label-control">Kanban visibility :</label>

<select class="custom-select" id="visibility" name="visibility" onchange="saveKanbanChanges()">
  <option selected>`+result.kanban.visibility+`</option>
`+(result.kanban.visibility != "visible" ? '  <option value="visible">visible</option>' : '')+`
`+(result.kanban.visibility != "private" ? '  <option value="private">private</option>' : '')+`
`+(result.kanban.visibility != "public" ? '  <option value="public">public</option>' : '')+`
</select>
 <hr class="sidebar-divider">

<div id="workgroup_users"></div>
 <hr class="sidebar-divider">
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
    <input type="hidden" id="backId" name="backId" value="`+result.kanban.background.replace('/wallpaper/','').replace('.jpg','')+`"/>
</div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="$('#edit').modal('hide');">Close</button>
<button type="button" class="btn btn-success" data-dismiss="modal" onclick="$('#edit').modal('hide');">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
`);
                    addWorkgroupUsers(result)
                    $('#edit').modal('show');
                }});
        });
        /**
         * Function to delete a kanban label
         */
        let deleteLabel = function(){
            let id = $("#deletelabel").val()
            $.ajax({
                url: '{{route('deleteLabel')}}',
                method: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    id:id,
                    kanban: {{ $kanban }}
                },
                success: function (result) {
                    $("#deletelabel").val("")
                    $("#label"+id).remove()
                    $("#remove"+id).remove()

                }
            })
        }
        /**
         * Function to create a kanban label
         */
        let addLabel = function(){
            let label = $("#label_title").val()
            let color = $("#label_color").val()
            $.ajax({
                url: '{{route('addLabel')}}',
                method: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    label: label,
                    color: color,
                    kanban: {{ $kanban }}
                },
                success: function (result) {
                    $("#label_title").val("")
                    $("#label_color").val("")
                    $('#kanbanlabels').append(`
                     <div id="label`+result.id+`"  class="btn mb-2" style="background-color: `+color+`">
                           `+label+`
                        </div>
                    `)
                    $('#deletelabel').append(`
                                       <option id="remove`+result.id+`" value="`+result.id+`">`+label+`</option>
                    `)
                }
            })
        }
        /**
         * Function to save kanban settings
         */
        let saveKanbanChanges = function() {
            let id = $("#id").val()
            let title = $("#title").val()
            let visibility = $("#visibility").val()
            let backId = $("#backId").val()
            $.ajax({
                url:  '{{route('editKanban')}}',
                method: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    id:id,
                    title:title,
                    visibility:visibility,
                    backId:backId,
                },
                success: function(result){
                    let elements = $('.kanban-user');
                    elements = Array.from(elements); //convert to array
                    elements.map(element => // map on kanban-boards to add edit button
                        {
                            $("#"+element.id).removeClass('border border-success border-4')
                            result.map(x => {
                                if(visibility === "private" && "user"+x.user_id === element.id){
                                    $("#"+element.id).attr('onclick','addKanbanUser("'+id+'","'+x.user_id+'")')
                                    $("#"+element.id).addClass('border border-success border-4')
                                }else if (visibility === "private"){
                                    $("#"+element.id).attr('onclick','addKanbanUser("'+id+'","'+element.id.replace('user','')+'")')
                                }else if(visibility !== "private"){
                                    $("#"+element.id).attr('onclick','')
                                    $("#"+element.id).addClass('border border-success border-4')
                                }
                            })
                        }
                    );
                    $('#content').css("background-image", "url(/img/wallpaper/"+backId+".jpg)");
                }});
        }
        /**
         * Function to display workgroup users
         */
        let addWorkgroupUsers = function(result){
            if(Object.keys(result.workgroupuser).length !== 0) {
                result.workgroupuser.map(x => {
                    $('#workgroup_users').append(`
                            <img id="user`+x.id+`" class="kanban-user img-profile rounded-circle `+(x.kanban_user === 1 ? 'border border-success border-4' : '')+`" style="width:50px;height:50px;"
                                 src="`+ '{{asset('img/')}}/'+x.picture +`" onclick='addKanbanUser("`+result.kanban.id+`","`+x.id+`")' title="`+x.name+` - `+x.email+`"> `)
                    if(result.kanban.visibility !== "private"){
                        $("#user"+x.id).attr('onclick','')
                    }else{
                        $("#user"+x.id).attr('onclick','addKanbanUser("'+result.kanban.id+'","'+x.id+'")')
                    }
                })
            }
            if(Object.keys(result.labels).length !== 0) {
                result.labels.map(x => {
                   $('#kanbanlabels').append(`
                     <div id='label`+x.label.id+`'  class="btn mb-2" style="background-color: `+x.label.color+`">
                           `+x.label.label+`
                        </div>
                    `)
                    $('#deletelabel').append(`
                                       <option id="remove`+result.id+`" value="`+x.label.id+`">`+x.label.label+`</option>
                    `)

                })

            }
        }
        /**
         * Function to add a user on a private kanban
         */
        let addKanbanUser = function(kanban_id, user_id){
            $.ajax({
                url:  '{{route('joinKanban')}}',
                method: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    kanban_id:kanban_id,
                    user_id:user_id,
                },
                success: function(result){
                    if(result === "1"){
                        $("#user"+user_id).addClass("border border-success border-4")
                    }else if(result === "0"){
                        $("#user"+user_id).removeClass("border border-success border-4")
                    }
                }});
        }
        /**
         * function to save all boards and card in database
         */
        let saveKanban = function(){
            let board = [];
            var kanbanBoard = $('.kanban-board').map(function(_, x) {
                let kanbanids = [];
                Array.prototype.slice.call(x.children[1].children).forEach( (x)=>{
                    kanbanids.push(x.dataset.eid)
                })
                return { id:x.dataset.id, items: kanbanids }; // Create an array with boards ID's and cards ID's
            }).get();
            board.push(kanbanBoard);
            $.ajax({ // Ajax to save kanban in DB.
                url: "{{ route('saveToDB') }}",
                method: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    boards: kanbanBoard,
                    kanbanId: {{ $kanban }}
                },
                success: function(result){
                    getBoards()
                }});
        }
        /**
         * function to add a new board
         */
        var addBoard = document.getElementById("addBoard");
        addBoard.addEventListener("click", function() {
            newid = Math.random().toString(36).substr(2, 9) // Create uid for the new board
            $.ajax({ // Ajax : fetch id max from boards
                url: "{{ route('boardMaxId') }}",
                method: 'get',
                data: {
                },
                success: function(result){
                    board = [
                        {
                            id: parseInt(result)+1,
                            title: "Kanban Default",
                            item: [
                            ]
                        }
                    ];
                    $.ajax({ // Ajax to save kanban in DB.
                        url: "{{ route('saveBoard') }}",
                        method: 'post',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            board: board,
                            kanbanId: {{ $kanban }}
                        },
                        success: function(result){
                            if(result === 'true'){
                                Kanban.addBoards(board);
                                saveKanban()
                            }
                        }});
                }});
        });
        /**
         * function to remove board from kanban
         */
        let archiveBoard = function(eid) {
            $.ajax({
                url: "{{ route('archiveBoard') }}",
                method: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    board_id:eid
                },
                success: function(result){
                     $("div[data-id=" + eid + "]").remove();
                    saveKanban()
                }
            });
        };
        /**
         * function to remove card from board
         */
        let archiveCard = function(eid) {
            $.ajax({
                url: "{{ route('archiveCard') }}",
                method: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    card_id:eid
                },
                success: function(result){
                    $("div[data-eid=" + eid + "]").remove();
                    saveKanban()
                }
            });

        };
        /**
         * function to show modal to edit board
         */
        let showEdit = function(eid) {
            $.ajax({
                url: "{{ route('getboard') }}",
                method: 'get',
                data: {
                    id:eid
                },
                success: function(result){
                    $('#modal-container').append (`
                            <div class="modal edit-modal" id="edit`+eid+`" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit board `+result[0].title+`</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#edit`+eid+`').modal('hide'); ">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" id="board_id" name="board_id" value="`+eid+`">
                                        <label for="title">Title:</label>
                                        <input class="form-control" type="text" id="title" name="title" value="`+result[0].title+`"><br>
                                    </div>
                                    <div class="modal-footer">
<button class="btn btn-danger" onclick="archiveBoard('`+eid+`'); $('#edit`+eid+`').modal('hide');">Archive board</button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="$('#edit`+eid+`').modal('hide');">Close</button>
                                        <button type="button" class="btn btn-success" onclick="saveChanges()">Save changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>`);
                    $('#edit'+eid+'').modal('show');
                }});
        };

        /**
         * Function to make user working on a card
         */
        let joinCard = function(user_id, card_id){
            $.ajax({
                url:  '{{route('joinCard')}}',
                method: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    card_id:card_id,
                    user_id:user_id,
                },
                success: function(result){
                    if(result === "1"){
                        $("#user"+user_id).addClass("border border-success border-4")
                    }else if(result === "0"){
                        $("#user"+user_id).removeClass("border border-success border-4")
                    }
                }});
        }
        /**
         * Function to save checklist
         */
        let saveChecklist = function(id){
            $.ajax({
                url:  '{{route('saveChecklist')}}',
                method: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    id:id,
                },
                success: function(result){
                }});
        }
        /**
         * Function to add checklist items on a specific card checklist
         */
        let addChecklistItem = function(cardId){
            let item = $('#item_title').val()
            $('#item_title').val("")
            $.ajax({
                url: "{{ route('addChecklistItem') }}",
                method: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    card_id: cardId,
                    item:item,
                },
                success: function(result){
                    $('#checklistitems').append(`
                            <div class="form-check m-2" id="item`+result.id+`">
                              <input class="form-check-input" type="checkbox" onchange="saveChecklist(`+result.id+`)" id="`+result.id+`"/>
                              <label class="form-check-label" for="`+result.id+`">`+result.label+`</label> @if(!isset($visibility))<button class="btn btn-danger btn-sm" onclick='deleteItem(`+result.id+`)'><i class="fas fa-times"></i></button>@endif
                            </div>
                        `)
                }});
        }
        /**
         * Function to add checklist to cart
         */
        let addChecklist = function(id){
            $.ajax({
                url: "{{ route('addChecklist') }}",
                method: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    card_id:id,
                },
                success: function(result){
                }});
        }
        /**
         * Function to save changes from card
         */
        let saveCardChanges = function() {
            let title = $("#title").val()
            let description = $("#description").val()
            let checklisttitle = $("#checklisttitle").val()
            let startDate = $("#start_date").val()
            let endDate = $("#end_date").val()
            let card_id = $("#card_id").val()
            $.ajax({
                url:  '{{route('editCard')}}',
                method: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    id:card_id,
                    title:title,
                    description:description,
                    checklisttitle:checklisttitle,
                    startDate:startDate,
                    endDate:endDate,
                },
                success: function(result){
                    $('#edit'+card_id).modal('hide');
                    getBoards()
                }});
        }
        /**
         * Function to save changes from boards
         */
        let saveChanges = function() {
            let title = $("#title").val()
            let board_id = $("#board_id").val()
            $.ajax({
                url:  '{{route('editBoard')}}',
                method: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    id:board_id,
                    title:title,
                },
                success: function(result){
                    $('#edit'+board_id).modal('hide');
                    getBoards()
                }});
        }
        /**
         * function to add a new card in a board
         */
        let addCard = function(boardid){
            let uidVerif = function(){
                $.ajax({
                    url: "{{ route('verifyCardId') }}",
                    method: 'post',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        board: boardid,
                        title:'New card'
                    },
                    success: function(result){
                        if(result != null){ // Verify if the new uid is not already used.
                            Kanban.addElement(
                                boardid,
                                {
                                    id:result,
                                    title:'New card',
                                }
                            );
                            saveKanban()
                        }else{
                            uidVerif()
                        }
                    }});
            }
            uidVerif()
        }
        /**
         * Function to delete item from a specific card checklist
         */
        let deleteItem = function(id){
            $.ajax({
                url: "{{ route('deleteItem') }}",
                method: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: id
                },
                success: function (result) {
                    $("#item"+id).remove()
                }
            })
        }

        /**
         * Function to delete an attachement from a specific card
         */
        let deleteFile = function(id){
            $.ajax({
                url: "{{ route('deleteFile') }}",
                method: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: id
                },
                success: function (result) {
                    $("#file"+id).remove()
                }
            })
        }
        /**
         * Function to add a comment on a card
         */
        let addComment = function(cardId){
            let comment = $('#comment').val()
            $('#comment').val("")
            $.ajax({
                url: "{{ route('addComment') }}",
                method: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    card_id: cardId,
                    comment:comment,
                },
                success: function(result){
                    $('#comments').append(`
                            <div id='comment`+result.id+`'>
                            <p class="border border-dark rounded p-2">`+result.message+` <button class="btn btn-danger btn-sm" onclick='deleteComment(`+result.id+`)'><i class="fas fa-times"></i></button></p>

                        </div>
`)
                }});
        }
        /**
         * Function to delete a comment from a specific card
         */
        let deleteComment = function(id){
            $.ajax({
                url: "{{ route('deleteComment') }}",
                method: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: id
                },
                success: function (result) {
                    $("#comment"+id).remove()
                }
            })
        }
        /**
         * Function to assign a label on a card
         */
        let useLabel = function(id,card_id){
            $.ajax({
                url: "{{ route('useLabel') }}",
                method: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: id,
                    card_id:card_id
                },
                success: function (result) {
                    if(result === "1"){
                        $("#label"+id).addClass("border border-success border-4")
                    }else if(result === "0"){
                        $("#label"+id).removeClass("border border-success border-4")
                    }
                }
            })
        }
        @endif
        const convertToDate = (d) => {
            const [year, month, day] = d.split("-");
            return new Date(year, month - 1, day);
        }
        /**
         * function to show modal to edit card
         */
        let showEditCard = function(eid){
            $.ajax({
                url: "{{ route('getcard') }}",
                method: 'get',
                data: {
                    id:eid
                },
                success: function(result){
                    const today = new Date();
                    const yyyy = today.getFullYear();
                    let mm = today.getMonth() + 1; // Months start at 0!
                    let dd = today.getDate();
                    const date = yyyy + '-' + mm + '-' + dd;

                    $('#modal-container').append (`
                    <div class="modal edit-card-modal" id="edit`+eid+`" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Edit card: `+result.card.title+`</h5><br>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#edit`+eid+`').modal('hide');">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
 <label for="labels">Card's labels :</label>
 <div id="labels">
 </div>
 <hr class="sidebar-divider">


<div class="datepicker date input-group">
 <label for="start_date">Start date : </label>
    <input type="date" placeholder="Start date" class="form-control `+(result.card.startDate != null && convertToDate(result.card.startDate) <= convertToDate(date) ? "bg-success text-light" : '')+` " id="start_date" `+(result.card.startDate != null  ? "value='"+result.card.startDate+"'" : '')+` @if(isset($visibility)) readonly @endif>
    <div class="input-group-append"><span class="input-group-text px-4"><i class="fa fa-calendar"></i></span></div>
</div><br>
<div class="datepicker date input-group">
    <label for="end_date">End date : </label>
    <input type="date" placeholder="End date" class="form-control `+(result.card.endDate != null && convertToDate(result.card.endDate) <= convertToDate(date) ? "bg-danger text-light" : '')+`" id="end_date" `+(result.card.endDate != null ? "value='"+result.card.endDate+"'" : '')+` @if(isset($visibility)) readonly @endif>
    <div class="input-group-append"><span class="input-group-text px-4"><i class="fa fa-calendar"></i></span></div>
</div>
 <hr class="sidebar-divider">


                                                <input type="hidden" id="card_id" name="card_id" value="`+result.card.id+`">
                                                <label for="title">Title:</label>
                                                <input class="form-control" type="text" id="title" name="title" value="`+result.card.title+`" @if(isset($visibility)) readonly @endif>
<hr class="sidebar-divider">
                                                <label for="description">Description:</label>
    <textarea class="form-control" id="description" name="description" rows="3" @if(isset($visibility)) readonly @endif>`+(result.card.description !== "null" && result.card.description !== null ? result.card.description : '')+`</textarea>
                                                @if(!isset($visibility))
                    <hr class="sidebar-divider" id='addChecklistDivider'>
                   <button class='btn btn-primary' id='addChecklist' onclick='addChecklist("`+result.card.id+`"); $("#editCardDynamic").removeAttr("hidden"); $(this).hide(); $("#addChecklistDivider").hide();' `+(result.checklist === null ? '' : 'hidden')+`>Add checklist</button> @endif
                                            <div id="editCardDynamic" class="mb-2" `+(result.checklist === null ? 'hidden' : '')+`>
                                             <hr class="sidebar-divider">
                <label for="checklisttitle" >Checklist :</label>
                <input  class='form-control' type='text' placeholder="Checklist title" id='checklisttitle' name='checklisttitle' value='`+(result.checklist === null ? 'New checklist' : result.checklist.title)+`'>
                <br><div id='checklistitems' class="mb-2"></div>
<div class="input-group">
                                              <input class="form-control" type="text" id="item_title" name="item_title" placeholder="Item title" value="">
                                              <div class="input-group-append">
                                                <button type="button" class="btn btn-outline-success" onclick="addChecklistItem(`+result.card.id+`)">Add</button>
                                              </div>
                                            </div>
</div>
                                            <div id="checklist-form"></div>
<hr class="sidebar-divider">
<label  for="files">Attachements :</label>

<div id="files"></div>
 @if(!isset($visibility))
<form action="{{ route('uploadFile') }}" id="upload" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" id="card_id" name="card_id" value="`+result.card.id+`">
        <div class="input-group mt-2">
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="file" name='file'
                  aria-describedby="attachment" accept=".txt, .doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document, image/*,.pdf" onchange="$('form#upload').submit();">
                <label class="custom-file-label" for="attachment">Choose file</label>
            </div>
        </div>
    </form>
    <hr class="sidebar-divider">
@else
    <hr class="sidebar-divider">
@endif


<div id="card_users"></div>
    <hr class="sidebar-divider">
    <label  for="comments">Comments :</label>
    <div id="comments"></div>
     @if(!isset($visibility))
    <div class="input-group mb-2">
    <input class="form-control" type="text" id="comment" name="comment" placeholder="Comment" value="">
                                              <div class="input-group-append">
                                                <button type="button" class="btn btn-outline-success" onclick="addComment(`+result.card.id+`)">Add</button>
                                              </div>@endif
                                        </div>
                                        <div class="modal-footer">
@if(!isset($visibility)) <button class="btn btn-danger" onclick="archiveCard('`+eid+`'); $('#edit`+eid+`').modal('hide');">Archive card</button> @endif
                                                <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="$('#edit`+eid+`').modal('hide');">Close</button>
                                                 @if(!isset($visibility))<button type="button" class="btn btn-success" onclick="saveCardChanges()">Save changes</button>@endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    `);
                    addEditFunctions(result)
                    $('#edit'+eid+'').modal('show');
                }});
        }
        /**
         * Function to display edit functions in card edit modal
         */
        let addEditFunctions = function(result){
            if(Object.keys(result.checklistitems).length !== 0) {
                result.checklistitems.map(x => {
                    $('#checklistitems').append(`
                            <div class="form-check m-2" id="item`+x.id+`">
                              <input class="form-check-input" type="checkbox" @if(!isset($visibility))   onchange="saveChecklist(this.id)"@endif id="`+x.id+`" `+(x.isChecked === 1 ? 'checked' : '')+`/>
                              <label class="form-check-label" for="`+x.id+`">`+x.label+`</label> @if(!isset($visibility))<button class="btn btn-danger btn-sm " onclick='deleteItem(`+x.id+`)'><i class="fas fa-times"></i></button>@endif
                            </div>
                        `)
                })
            }
            if(Object.keys(result.workgroupuser).length !== 0) {
                result.workgroupuser.map(x => {
                    $('#card_users').append(`
                            <img id="user`+x.id+`" class="img-profile rounded-circle `+(x.card_user === 1 ? 'border border-success border-4' : '')+`" style="width:50px;height:50px;"
                                 src="`+ '{{asset('img/')}}/'+x.picture +`" @if(!isset($visibility)) onclick="joinCard(`+x.id+`,`+result.card.id+`)"@endif title="`+x.name+` - `+x.email+`">
                        `)
                })
            }
            if(Object.keys(result.attachments).length !== 0) {
                result.attachments.map(x => {
                    $('#files').append(`
                        <li id='file`+x.id+`'>
                            <a href='/showFile/`+x.id+`' target='_blank'>`+x.original_name+`</a>
                             @if(!isset($visibility))<button class="btn btn-danger btn-sm" onclick='deleteFile(`+x.id+`)'><i class="fas fa-times"></i></button>@endif
                        </li>
                    `)
                })
            }
            if(Object.keys(result.comments).length !== 0) {
                result.comments.map(x => {
                    $('#comments').append(`
                        <div id='comment`+x.id+`'>
                            <p class="border border-dark rounded p-2">`+x.message+`@if(!isset($visibility)) <button class="btn btn-danger btn-sm" onclick='deleteComment(`+x.id+`)'><i class="fas fa-times"></i></button>@endif</p>

                        </div>
                    `)
                })
            }
            if(Object.keys(result.labels).length !== 0) {
                result.labels.map(x => {
                    $('#labels').append(`
                        <div id='label`+x[0].id+`' class="btn `+( x[1]  ? 'border border-success border-4' : '')+`" style="background-color: `+x[0].color+`" @if(!isset($visibility))onclick='useLabel(`+x[0].id+`,`+result.card.id+`)'@endif>
                           `+x[0].label+`
                        </div>
                    `)
                })
            }
        }

        /**
         * Create the kanban
         */
        let Kanban = new jKanban({
            element          : '#myKanban',                                           // selector of the kanban container
            gutter           : '15px',                                       // gutter of the board
            widthBoard       : '250px',                                      // width of the board
            responsivePercentage: false,                                    // if it is true I use percentage in the width of the boards and it is not necessary gutter and widthBoard
            dragItems        : @if(!isset($visibility)) true @else false @endif,                                         // if false, all items are not draggable
            boards           : [],                                           // json of boards
            dragBoards       : @if(!isset($visibility)) true @else false @endif,                                         // the boards are draggable, if false only item can be dragged
            itemAddOptions: {
                enabled: true,                                              // add a button to board for easy item creation
                content: "Add card +",                                                // text or html content of the board button
                class: 'kanban-title-button btn btn-primary w-100',         // default class of the button
                footer: true,                                                // position the button on footer
            },
            click            : function (el) { showEditCard(el.dataset.eid);/*$('#card'+el.dataset.eid).modal('show');*/ },                             // callback when any board's item are clicked
            context          : function (el, event) {},                      // callback when any board's item are right clicked
            dragEl           : function (el, source) {},                     // callback when any board's item are dragged
            dragendEl        : function (el) { @if(!isset($visibility)) saveKanban() @endif},                             // callback when any board's item stop drag
            dropEl           : function (el, target, source, sibling) {},    // callback when any board's item drop in a board
            dragBoard        : function (el, source) {},                     // callback when any board stop drag
            dragendBoard     : function (el) {@if(!isset($visibility)) saveKanban() @endif},                             // callback when any board stop drag
            buttonClick      : function(el, boardId) {  @if(!isset($visibility)) addCard(boardId) @endif},                     // callback when the board's button is clicked
            propagationHandlers: [],
        })
        $(document).ready(function(e) {
            actualBackground();
            getBoards(); // fetch boards from database after page load
            $(document).on('hide.bs.modal','.edit-modal', function () {
                @if(!isset($visibility))
                saveChanges()
                @endif
                $('.edit-modal').remove(); // Remove edit board modal on close event
            });
            $(document).on('hide.bs.modal','.edit-card-modal', function () {
                @if(!isset($visibility))
                saveCardChanges()
                @endif
                $('.edit-card-modal').remove(); // Remove edit card modal on close event
            });
            $(document).on('hide.bs.modal','.manage-modal', function () {
                saveKanbanChanges()
                $('.manage-modal').remove(); // Remove edit board modal on close event
            });

        });
        /**
         *  Change Background and use the background from the Kanban
         */
        let actualBackground = function() {
            let div = document.getElementById('content');
            if(div !== null)
            {
                div.style.backgroundImage = "url('/img{{ $background }}')";
            }
        }
        /**
         * Fetch boards from DB and add them
         */
        let getBoards = function(){
            $.ajax({
                url: "{{ route('getBoards') }}",
                method: 'get',
                data: {
                    id:{{ $kanban }}
                },
                success: function(result){
                    $('.kanban-container').html('');
                    result = JSON.parse(result)
                    var boardsList = [];
                    $.each(result, function (board) {
                        var taskList = [];
                        $.each(result[board].item, function (task) { // build cards array
                            taskList.push({
                                id: result[board].item[task].id,
                                title: result[board].item[task].title,
                            })
                        });
                        boardsList.push({ // build boards array
                            id: result[board].id,
                            title: result[board].title,
                            item: taskList
                        });
                    });
                    Kanban.addBoards(boardsList); // Add boards to kanban
                    let elements = $('.kanban-board');
                    elements = Array.from(elements); //convert to array
                    elements.map(element => // map on kanban-boards to add edit button
                        {
                            let settingsBtn = document.createElement("button")
                            settingsBtn.innerHTML = "📝";
                            settingsBtn.setAttribute('onclick',"showEdit("+element.dataset.id+"); /*archiveBoard("+element.dataset.id+")*/")
                            settingsBtn.classList = "btn float-right";
                            element.children[0].append(settingsBtn)
                        }
                    );
                }});
        }
    </script>
@stop

