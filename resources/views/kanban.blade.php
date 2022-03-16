@extends('layouts.template')

@section('title', 'Kanban')

@section('content')
<style>
    .custom-button {
        border: none;
        color: white;
        background-color:transparent;
        padding: left;
        margin: 10px;
        text-align: right;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        right: 0px;
      }
</style>
<div id="actions" class="mb-4 w-100"><button class="btn btn-success" id="addBoard">Add board</button></div>
<br>
    <div id="myKanban" style="overflow: auto;" class="mb-3"></div>
    <div id="modal-container"></div>

@stop
@section('scripts')
@php
    $count = 0;
@endphp
    <script>

        const slider = document.querySelector('#myKanban');
        let isDown = false;
        let startX;
        let scrollLeft;
        slider.addEventListener('mousedown', (e) => {
        isDown = true;
        slider.classList.add('active');
        startX = e.pageX - slider.offsetLeft;
        scrollLeft = slider.scrollLeft;
        });
        slider.addEventListener('mouseleave', () => {
        isDown = false;
        slider.classList.remove('active');
        });
        slider.addEventListener('mouseup', () => {
        isDown = false;
        slider.classList.remove('active');
        });
        slider.addEventListener('mousemove', (e) => {
        if(!isDown) return;
        e.preventDefault();
        const x = e.pageX - slider.offsetLeft;
        const walk = (x - startX) * 3; //scroll-fast
        slider.scrollLeft = scrollLeft - walk;
        });
        /**
         * function to save all boards and card in database
         */
        let saveKanban = async function(){
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
            return 1;
        }
        /**
         * function to add a new board
         */
        var addBoard = document.getElementById("addBoard");
        addBoard.addEventListener("click", function() {
            $.ajax({ // Ajax : fetch id max from tables
                  url: "{{ route('tablemaxid') }}",
                  method: 'get',
                  data: {
                    "_token": "{{ csrf_token() }}"
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
                      //console.log(board);
                      $.ajax({ // Ajax to save kanban in DB.
                        url: "{{ route('saveTable') }}",
                        method: 'post',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            board: board,
                            kanbanId: 1
                        },
                        success: function(result){
                            if(result =='true'){
                                Kanban.addBoards(board);
                                getBoards()
                            }
                        }});
                  }});
            // Save new board in tables

        });
        let removeBoard = function(eid) {
            // To Do Ajax : remove board from bdd
            Kanban.removeBoard(eid.toString());
            saveKanban()
        };
        /**
         * function to add a new card in a board
         */
        let addCard = function(tableid){
            let uidVerif = function(){
                newuid = Math.random().toString(36).substr(2, 9) // Create uid for the new card
                console.log(newuid)
                $.ajax({
                  url: "{{ route('verifyCardId') }}",
                  method: 'post',
                  data: {
                    "_token": "{{ csrf_token() }}",
                     uid: newuid,
                     table: tableid,
                      title:'New card toto'
                  },
                  success: function(result){
                      if(result == 'true'){ // Verify if the new uid is not already used.
                        Kanban.addElement(
                            tableid,
                            {
                                id: newuid,
                                title:'New card toto',
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

                        click            : function (el) { console.log('#card'+el.dataset.eid); $('#card'+el.dataset.eid).modal('show'); },                             // callback when any board's item are clicked
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
                            $('#modal-container').append (`
                            <div class="modal" id="card`+result[board].item[task].id+`" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">`+result[board].item[task].title+`</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#card`+result[board].item[task].id+`').modal('hide');">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        ...
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="$('#card`+result[board].item[task].id+`').modal('hide');">Close</button>
                                        <button type="button" class="btn btn-success">Save changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                            `);
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

                    let id=0;
                    let header = $('.kanban-board-header');
                    header.each(function(index){
                        console.log(this)
                        let settingsBtn = document.createElement("button")
                        settingsBtn.innerHTML = "📝";
                        settingsBtn.setAttribute('onclick',"alert('yo "+id+"')")
                        settingsBtn.classList = "btn float-right align-top";
                        $(this).append(settingsBtn)
                        id++
                    });


            }});
        }

    </script>
@stop
