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
        <a class="nav-link"> <!-- TO DO : Open modal with kanban settings-->
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
    </style>
    <div id="myKanban" style="overflow: auto;" class="mb-3"></div>
    <div id="modal-container"></div>

@stop
@section('scripts')

    <script>
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
                    console.log(result)
                    board = [
                        {
                            id: parseInt(result)+1,
                            title: "Kanban Default",
                            item: [
                            ]
                        }
                    ];
                    console.log(board);
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
        let removeBoard = function(eid) {
            Kanban.removeBoard(eid.toString());
            saveKanban()
        };
        /**
         * function to remove card from board
         */
        let removeCard = function(eid) {
            Kanban.removeElement(eid.toString());
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
                    console.log(result[0].title)
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
                                        <input type="text" id="title" name="title" value="`+result[0].title+`"><br>
                                        <button class="btn btn-danger mt-5" onclick="removeBoard('`+eid+`'); $('#edit`+eid+`').modal('hide');">Remove board</button>
                                    </div>
                                    <div class="modal-footer">
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
                    console.log("============Debug result=============")
                    console.log(result)
                    console.log("============END debug result=============")
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
    <input type="date" placeholder="Start date" class="form-control" id="start_date" `+(result.card.startDate != null ? "value='"+result.card.startDate+"'" : '')+`>
    <div class="input-group-append"><span class="input-group-text px-4"><i class="fa fa-calendar"></i></span></div>
</div><br>
<div class="datepicker date input-group">
    <label for="end_date">End date : </label>
    <input type="date" placeholder="End date" class="form-control" id="end_date" `+(result.card.endDate != null ? "value='"+result.card.endDate+"'" : '')+`>
    <div class="input-group-append"><span class="input-group-text px-4"><i class="fa fa-calendar"></i></span></div>
</div>
 <hr class="sidebar-divider">
                                                <input type="hidden" id="card_id" name="card_id" value="`+result.card.id+`">
                                                <label for="title">Title:</label>
                                                <input class="form-control" type="text" id="title" name="title" value="`+result.card.title+`">
                                                <hr class="sidebar-divider">
<button class='btn btn-primary' id='addChecklist' onclick='addChecklist("`+result.card.id+`"); $("#editCardDynamic").removeAttr("hidden"); $(this).hide();' `+(result.checklist === null ? '' : 'hidden')+`>Add checklist</button>

                                            <div id="editCardDynamic" class="mb-2" `+(result.checklist === null ? 'hidden' : '')+`>
                <label for="checklisttitle" >Checklist :</label>
                <input  class='form-control' type='text' placeholder="Checklist title" id='checklisttitle' name='checklisttitle' value='`+(result.checklist === null ? 'New checklist' : result.checklist.title)+`'>
                <br><div id='checklistitems'></div>
<div class="input-group">
                                              <input class="form-control" type="text" id="item_title" name="item_title" placeholder="Item title" value="">
                                              <div class="input-group-append">
                                                <button type="button" class="btn btn-outline-success" onclick="addChecklistItem(`+result.card.id+`)">Add</button>
                                              </div>
                                            </div>
</div>
                                            <div id="checklist-form"></div>
                                            </div>
                                            <div class="modal-footer">
                                            <button class="btn btn-danger" onclick="removeCard('`+eid+`'); $('#edit`+eid+`').modal('hide');">Remove card</button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="$('#edit`+eid+`').modal('hide');">Close</button>
                                                <button type="button" class="btn btn-success" onclick="saveCardChanges()">Save changes</button>
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
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" onchange="saveChecklist(this.id)" id="`+x.id+`" `+(x.isChecked === 1 ? 'checked' : '')+`/>
                              <label class="form-check-label" for="`+x.id+`">`+x.label+`</label>
                            </div>
                        `)
                    })
                }
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
                    console.log("SUCCESS : ",result)
                    $('#checklistitems').append(`
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" onchange="saveChecklist(`+result.id+`)" id="`+result.id+`"/>
                              <label class="form-check-label" for="`+result.id+`">`+result.label+`</label>
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
                    console.log("SUCCESS : ",result)
                }});
        }
        let saveCardChanges = function() {
            let title = $("#title").val()
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
         * Create the kanban
         */
        let Kanban = new jKanban({
            element          : '#myKanban',                                           // selector of the kanban container
            gutter           : '15px',                                       // gutter of the board
            widthBoard       : '250px',                                      // width of the board
            responsivePercentage: false,                                    // if it is true I use percentage in the width of the boards and it is not necessary gutter and widthBoard
            dragItems        : true,                                         // if false, all items are not draggable
            boards           : [],                                           // json of boards
            dragBoards       : true,                                         // the boards are draggable, if false only item can be dragged
            itemAddOptions: {
                enabled: true,                                              // add a button to board for easy item creation
                content: "Add card +",                                                // text or html content of the board button
                class: 'kanban-title-button btn btn-primary w-100',         // default class of the button
                footer: true,                                                // position the button on footer
            },
            click            : function (el) { showEditCard(el.dataset.eid);/*$('#card'+el.dataset.eid).modal('show');*/ },                             // callback when any board's item are clicked
            context          : function (el, event) {},                      // callback when any board's item are right clicked
            dragEl           : function (el, source) {},                     // callback when any board's item are dragged
            dragendEl        : function (el) { saveKanban() },                             // callback when any board's item stop drag
            dropEl           : function (el, target, source, sibling) {},    // callback when any board's item drop in a board
            dragBoard        : function (el, source) {},                     // callback when any board stop drag
            dragendBoard     : function (el) {saveKanban()},                             // callback when any board stop drag
            buttonClick      : function(el, boardId) {  /*removeBoard(boardId); */ addCard(boardId)},                     // callback when the board's button is clicked
            propagationHandlers: [],
        })

        $(document).ready(function() {
            getBoards(); // fetch boards from database after page load
            $(document).on('hide.bs.modal','.edit-modal', function () {
                saveChanges()
                $('.edit-modal').remove(); // Remove edit board modal on close event
            });
            $(document).on('hide.bs.modal','.edit-card-modal', function () {
                saveCardChanges()
                $('.edit-card-modal').remove(); // Remove edit card modal on close event
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
                        console.log(result[board])
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
                    console.log(boardsList)
                    Kanban.addBoards(boardsList); // Add boards to kanban
                    let elements = $('.kanban-board');
                    elements = Array.from(elements); //convert to array
                    elements.map(element => // map on kanban-boards to add edit button
                        {
                            let settingsBtn = document.createElement("button")
                            settingsBtn.innerHTML = "📝";
                            settingsBtn.setAttribute('onclick',"showEdit("+element.dataset.id+"); /*removeBoard("+element.dataset.id+")*/")
                            settingsBtn.classList = "btn float-right";
                            element.children[0].append(settingsBtn)
                        }
                    );
                }});
        }

    </script>
@stop
