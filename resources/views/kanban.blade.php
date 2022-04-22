@extends('layouts.template')

@section('title', 'Kanban')

@section('actions')
    <li class="nav-item active">
        <a class="nav-link" id="addBoard">
            <i class="fas fa-plus-square"></i>
            <span>Add board</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <li class="nav-item active">
        <a class="nav-link" id="manageKanban"> <!-- TO DO : Open modal with kanban settings-->
            <i class="fas fa-cog"></i>
            <span>Manage kanban</span></a>
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
 <label for="visibility" class="label-control">Kanban visibility :</label>

<select class="custom-select" id="visibility" name="visibility" onchange="saveKanbanChanges()">
  <option selected>`+result.kanban.visibility+`</option>
`+(result.kanban.visibility != "visible" ? '  <option value="visible">visible</option>' : '')+`
`+(result.kanban.visibility != "private" ? '  <option value="private">private</option>' : '')+`
`+(result.kanban.visibility != "public" ? '  <option value="public">public</option>' : '')+`
</select>
 <hr class="sidebar-divider">

<div id="workgroup_users"></div>
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
        let saveKanbanChanges = function() {
            let id = $("#id").val()
            let title = $("#title").val()
            let visibility = $("#visibility").val()
            $.ajax({
                url:  '{{route('editKanban')}}',
                method: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    id:id,
                    title:title,
                    visibility:visibility,
                },
                success: function(result){
                    console.log(result)
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
                }});
        }
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
        }
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
                }
            });
            saveKanban()
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
                }
            });
            saveKanban()
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
        @endif
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
                    console.log(result)
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
<div class="datepicker date input-group">
 <label for="start_date">Start date : </label>
    <input type="date" placeholder="Start date" class="form-control" id="start_date" `+(result.card.startDate != null ? "value='"+result.card.startDate+"'" : '')+` @if(isset($visibility)) readonly @endif>
    <div class="input-group-append"><span class="input-group-text px-4"><i class="fa fa-calendar"></i></span></div>
</div><br>
<div class="datepicker date input-group">
    <label for="end_date">End date : </label>
    <input type="date" placeholder="End date" class="form-control" id="end_date" `+(result.card.endDate != null ? "value='"+result.card.endDate+"'" : '')+` @if(isset($visibility)) readonly @endif>
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
                            <button class="btn btn-danger btn-sm" onclick='deleteFile(`+x.id+`)'><i class="fas fa-times"></i></button>
                        </li>
                    `)
                })
            }
        }
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
                    console.log(result)
                }
            })
        }
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
                    console.log(result)
                }
            })
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
            $("#upload").submit(function(e) {
                e.preventDefault(); // <==stop page refresh==>
                let formData = new FormData();
                formData.append("file", fileupload.files[0]);
                fetch('{{route('uploadFile')}}', {
                    method: "POST",
                    body: formData
                });
            });
        });
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

