@extends('layouts.template')

@section('title', 'Kanban')

@section('content')
    <button class="btn btn-success m-2" id="addDefault">Add "Default" board</button>
    <button class="btn btn-success m-2" id="addToDo">Add element in "To Do" Board</button>
    <button class="btn btn-danger m-2" id="removeBoard">Remove "Done" Board</button>
<br>
    <div id="myKanban" style="overflow: auto;" class="mb-3"></div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@stop
@section('scripts')
@php
    $count = 0;
@endphp
    <script>
        myBoards = [
                @foreach($tables as $table)
                {
                    id: "{{$table->id}}",
                    title: "{{$table->title}}",
                    item: [
                        @foreach($cards as $card)
                            @if($card->isActive == true && $table->id == $card->table_id)
                            {
                                id: "{{$card->id}}",
                                title: "{{$card->title}} {{$card->tables->title}}",
                                class: "test{{$card->id}}",
                            },
                            @php
                                $count++;
                            @endphp
                            @endif
                        @endforeach 
                    ]
                },
                @endforeach
               ]

        let KanbanTest = new jKanban({
            element          : '#myKanban',                                           // selector of the kanban container
            gutter           : '15px',                                       // gutter of the board
            widthBoard       : '250px',                                      // width of the board
            responsivePercentage: false,                                    // if it is true I use percentage in the width of the boards and it is not necessary gutter and widthBoard
            dragItems        : true,                                         // if false, all items are not draggable
            boards           : myBoards,                                           // json of boards
            dragBoards       : true,                                         // the boards are draggable, if false only item can be dragged
            itemAddOptions: {
                enabled: false,                                              // add a button to board for easy item creation
                content: '+',                                                // text or html content of the board button   
                class: 'kanban-title-button btn btn-default btn-xs',         // default class of the button
                footer: false                                                // position the button on footer
            },    
            itemHandleOptions: {
                enabled             : false,                                 // if board item handle is enabled or not
                handleClass         : "item_handle",                         // css class for your custom item handle
                customCssHandler    : "drag_handler",                        // when customHandler is undefined, jKanban will use this property to set main handler class
                customCssIconHandler: "drag_handler_icon",                   // when customHandler is undefined, jKanban will use this property to set main icon handler class. If you want, you can use font icon libraries here
                customHandler       : "<span class='item_handle'>+</span> %title% "  // your entirely customized handler. Use %title% to position item title 
                                                                                    // any key's value included in item collection can be replaced with %key%
            },
            click            : function (el) { console.log("Helloo") },                             // callback when any board's item are clicked
            context          : function (el, event) {},                      // callback when any board's item are right clicked
            dragEl           : function (el, source) {},                     // callback when any board's item are dragged
            dragendEl        : function (el) { saveKanban() },                             // callback when any board's item stop drag
            dropEl           : function (el, target, source, sibling) {},    // callback when any board's item drop in a board
            dragBoard        : function (el, source) {},                     // callback when any board stop drag
            dragendBoard     : function (el) {saveKanban()},                             // callback when any board stop drag
            buttonClick      : function(el, boardId) {},                     // callback when the board's button is clicked
            propagationHandlers: [],   
    

        })
        let toDoButton = document.getElementById('addToDo');
        toDoButton.addEventListener('click',function(){
            KanbanTest.addElement(
                '_todo',
                {
                    'title':'Test Add',
                }
            );
        });
        let addBoardDefault = document.getElementById('addDefault');
        addBoardDefault.addEventListener('click', function () {
            KanbanTest.addBoards(
                [{
                    id: "_default",
                    title: "Kanban Default",
                    class: "default",
                    //dragTo: ["_working"],
                    item: [
                        {
                            id: "_default-1",
                            title: "Default item 1",
                            dragend: function(el) { console.log("END DRAG: " + el.dataset.eid); saveKanban();},
                            //drag: function(el) { console.log("START DRAG: " + el.dataset.eid); },
                            //drop: function(el) { console.log("DROPPED: " + el.dataset.eid); }
                            //click: function() { alert("click"); },
                            //class: ["peppe", "bello"]
                        },
                        {
                            id: "_default-2",
                            title: "Default item 2",
                            dragend: function(el) { console.log("END DRAG: " + el.dataset.eid); saveKanban();},
                        },
                        {
                            id: "_default-3",
                            title: "Default item 3",
                            dragend: function(el) { console.log("END DRAG: " + el.dataset.eid); saveKanban();},
                        },
                    ]
                }]
            )
        });
        let removeBoard = document.getElementById('removeBoard');
        removeBoard.addEventListener('click',function(){
            KanbanTest.removeBoard('_done');
        });

        function saveKanban(){
            var kanbanBoard = $('.kanban-board').map(function(_, x) {
                let kanbanids = [];
                Array.prototype.slice.call(x.children[1].children).forEach( (x)=>{
                    kanbanids.push(x.dataset.eid)
                })
                return "{'"+x.dataset.id+"':'"+kanbanids+"'}";
            }).get();
            console.log(kanbanBoard);
        }
    </script>
@stop
