@extends('layouts.template')

@section('title', 'Kanban')

@section('content')
    <style>
    .kanban-container {
        width: auto;
    }
    </style>
    <div id="actions" class="mb-4 w-100"><button class="btn text-white" style="background-color: #8ED081" id="addBoard">Add board</button></div>
    <br>
    <div id="myKanban" style="overflow: auto;" class="mb-3"></div>
    <div id="modal-container"></div>

@stop
@section('scripts')
    @php
        $count = 0;
    @endphp
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
            console.log( kanbanBoard)
            $.ajax({ // Ajax to save kanban in DB.
                url: "{{ route('saveToDB') }}",
                method: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    boards: kanbanBoard,
                    kanbanId: 1
                },
                success: function(result){
                    console.log(result)
                    getBoards()
                }});
        }
        /**
         * function to add a new board
         */
        var addBoard = document.getElementById("addBoard");
        addBoard.addEventListener("click", function() {
            newuid = Math.random().toString(36).substr(2, 9) // Create uid for the new board

            $.ajax({ // Ajax : fetch id max from boards
                url: "{{ route('boardMaxId') }}",
                method: 'get',
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success: function(result){
                    console.log(result)
                    board = [
                        {
                            id: parseInt(result)+1,
                            uid: newuid,
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
                            kanbanId: 1
                        },
                        success: function(result){
                            if(result =='true'){
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
                                        <input type="hidden" id="uid" name="uid" value="`+eid+`">
                                        <label for="title">Title:</label>
                                        <input type="text" id="title" name="title" value="`+result[0].title+`"><br>
                                        <button class="btn btn-danger mt-5" onclick="removeBoard('`+eid+`'); $('#edit`+eid+`').modal('hide');">Remove board</button>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="$('#edit`+eid+`').modal('hide');">Close</button>
                                        <button type="button" class="btn btn-success" onclick="saveChanges('`+eid+`','{{route('editBoard')}}')">Save changes</button>
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
                    console.log(result.checklistitems)
                    console.log("============END debug result=============")

                    $('#modal-container').append (`
                    <div class="modal edit-card-modal" id="edit`+eid+`" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Edit card: `+result.title+`</h5><br>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#edit`+eid+`').modal('hide');">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" id="uid" name="uid" value="`+result.uid+`">
                                                <label for="title">Title:</label>
                                                <input type="text" id="title" name="title" value="`+result.title+`"><br>
                                                <button class="btn btn-danger mt-5" onclick="removeCard('`+eid+`'); $('#edit`+eid+`').modal('hide');">Remove card</button>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="$('#edit`+eid+`').modal('hide');">Close</button>
                                                <button type="button" class="btn btn-success" onclick="saveChanges('`+eid+`','{{route('editCard')}}')">Save changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    `);
                    $('#edit'+eid+'').modal('show');
                }});
        }

        let saveChanges = function(eid, route) {
            let title = $("#title").val()
            console.log(title)
            $.ajax({
                url:  route,
                method: 'post',
                data: {
                    id:eid,
                    title:title
                },
                success: function(result){
                    $('#edit'+eid).modal('hide');
                    getBoards()
                }});
        }
        /**
         * function to add a new card in a board
         */
        let addCard = function(boardid){
            let uidVerif = function(){
                newuid = Math.random().toString(36).substr(2, 9) // Create uid for the new card
                console.log(newuid)
                $.ajax({
                    url: "{{ route('verifyCardId') }}",
                    method: 'post',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        uid: newuid,
                        board: boardid,
                        title:'New card'
                    },
                    success: function(result){
                        if(result === 'True'){ // Verify if the new uid is not already used.
                            Kanban.addElement(
                                boardid,
                                {
                                    id: newuid,
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
            click            : function (el) { console.log('#edit'+el.dataset.eid); showEditCard(el.dataset.eid);/*$('#card'+el.dataset.eid).modal('show');*/ },                             // callback when any board's item are clicked
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
                $('.edit-modal').remove(); // Remove edit board modal on close event
            });
            $(document).on('hide.bs.modal','.edit-card-modal', function () {
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
                    id:1
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
