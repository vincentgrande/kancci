@extends('layouts.template')

@section('title', 'Kanban')

@section('content')

    <button class="btn btn-success m-2" id="addDefault">Add "Default" board</button>
    <button class="btn btn-success m-2" id="addToDo">Add element in "To Do" Board</button>
    <button class="btn btn-danger m-2" id="removeBoard">Remove "Done" Board</button>

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
    <script>
        myBoards = [
            {
                id: "_todo",
                title: "To Do",
                //class: "info,good",
                //dragTo: ["_working"],
                item: [
                    {
                        id: "_test_delete",
                        title: "<div class='position-relative' data-toggle='modal' data-target='#exampleModal'>" +
                                    "<p class='bg-danger text-light text-center w-50 d-inline-block rounded top-0 start-0' style='font-size: 15px;'>Vincent</p>" +
                                    "<div class=' float-right top-0 end-0'><i class='far fa-edit'></i></div>" +
                                    "<p>Try drag this (Look the console)</p>" +
                                    "<p class='bg-success text-light  text-center d-inline-block rounded-circle bottom-0 p-1 mr-1' style='font-size: 10px;'>VG</p>" +
                                    "<p class='bg-danger text-light  text-center d-inline-block rounded-circle bottom-0 p-1 mr-1' style='font-size: 10px;'>JW</p>" +
                            "</div>",
                        dragend: function(el) { console.log("END DRAG: " + el.dataset.eid); },
                        //drag: function(el) { console.log("START DRAG: " + el.dataset.eid); },
                        //drop: function(el) { console.log("DROPPED: " + el.dataset.eid); }
                        //click: function() { alert("click"); },
                        //class: ["peppe", "bello"]
                    },
                    {
                        id: "_test_delete",
                        title: "Try Click This!",
                        dragend: function(el) { console.log("END DRAG: " + el.dataset.eid); },
                    }
                ]
            },
            {
                id: "_working",
                title: "Working",
                item: [
                    {
                        id: "_test_delete",
                        title: "Do Something!",
                        dragend: function(el) { console.log("END DRAG: " + el.dataset.eid); },
                    },
                    {
                        id: "_test_delete",
                        title: "Run?",
                        dragend: function(el) { console.log("END DRAG: " + el.dataset.eid); },
                    }
                ]
            },
            {
                id: "_done",
                title: "Done",
                item: [
                    {
                        id: "_test_delete",
                        title: "<div data-toggle='modal' data-target='#myModal'>Open modal</div>",
                        dragend: function(el) { console.log("END DRAG: " + el.dataset.eid); },
                    },
                    {
                        id: "_test_delete2",
                        title: "Ok!",
                        dragend: function(el) { console.log("END DRAG: " + el.dataset.eid); },
                    }
                ]
            }
        ]
        let KanbanTest = new jKanban({
            element: "#myKanban",
            boards: myBoards,
            addItemButton: true,
            /*buttonContent: '+',

            buttonClick: function(el, boardId) {
                console.log(el);
                console.log(boardId);
                // create a form to enter element
                let formItem = document.createElement("form");
                formItem.setAttribute("class", "itemform");
                formItem.innerHTML =
                    '<div class="form-group"><textarea class="form-control" rows="2" autofocus></textarea></div><div class="form-group"><button type="submit" class="btn btn-primary btn-xs pull-right">Submit</button><button type="button" id="CancelBtn" class="btn btn-default btn-xs pull-right">Cancel</button></div>';
                KanbanTest.addForm(boardId, formItem);
                formItem.addEventListener("submit", function(e) {
                    e.preventDefault();
                    let text = e.target[0].value;
                    KanbanTest.addElement(boardId, {
                        title: text
                    });
                    formItem.parentNode.removeChild(formItem);
                });
                document.getElementById("CancelBtn").onclick = function() {
                    formItem.parentNode.removeChild(formItem);
                };
            },*/

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
                    //class: "info,good",
                    //dragTo: ["_working"],
                    item: [
                        {
                            id: "_default-1",
                            title: "Default item 1",
                            dragend: function(el) { console.log("END DRAG: " + el.dataset.eid); },
                            //drag: function(el) { console.log("START DRAG: " + el.dataset.eid); },
                            //drop: function(el) { console.log("DROPPED: " + el.dataset.eid); }
                            //click: function() { alert("click"); },
                            //class: ["peppe", "bello"]
                        },
                        {
                            id: "_default-2",
                            title: "Default item 2",
                            dragend: function(el) { console.log("END DRAG: " + el.dataset.eid); },
                        },
                        {
                            id: "_default-3",
                            title: "Default item 3",
                            dragend: function(el) { console.log("END DRAG: " + el.dataset.eid); },
                        },
                    ]
                }]
            )
        });

        let removeBoard = document.getElementById('removeBoard');
        removeBoard.addEventListener('click',function(){
            KanbanTest.removeBoard('_done');
        });
    </script>
@stop
