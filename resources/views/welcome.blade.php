<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>KANCCI</title>
    <link href="css/all.min.css" rel="stylesheet" type="text/css">
    <link href="css/jkanban.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.css" rel="stylesheet">
</head>

<body id="page-top" class="bg-light mh-100">

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content" class="bg-gray">

            <!-- Topbar -->
            <nav class=" bg-primary mb-4 shadow position-relative">
                <a class="d-flex text-center align-items-center justify-content-center text-decoration-none" href="{{ route('index') }}">
                    <div class="text-light font-weight-bold h1 rotate-n-15 text-center">
                        <i class="fab fa-trello"></i>
                    </div>
                    <div id="test" class="text-light text-center h1 font-weight-bold m-3">KANCCI</div>
                </a>
            </nav>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!-- Content Row -->
                <div class="row text-dark  justify-content-center">
                    <div id="welcome-1" class=" w-100"><h2 class="text-center">Welcome to Kancci ! 🎉 </h2></div>
                    <br><br>
                    <div id="welcome-2" class=" w-100">
                        <h3 class="text-center ">Try draging card below & register to discover all the kanban's functionnalities !</h3>
                    </div><br>
                    <div id="welcome-3" class="text-center w-100 ">
                        <a class="btn btn-success m-2" href="{{ route('login') }}">Login</a>
                        <a class="btn btn-success m-2" href="{{ route('register') }}">Register</a>
                    </div>

                    <div id="myKanban" style="overflow: auto;" class="mb-3 "></div>
                    <div class="modal edit-card-modal" id="welcome" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Woops !</h5><br>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#welcome').modal('hide');">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>It seems you are not logged in 😓</p>
                                    <p>You need to be registered and connected to use all the kanban's functionnalities ! 👌</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="$('#welcome').modal('hide');">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-primary ">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; KANCCI - 2022</span>
                </div>
            </div>
        </footer>
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>


<script src="js/app.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src='js/jkanban.min.js'></script>
<script src="js/sb-admin-2.min.js"></script>
<script>
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
        click            : function (el) { $('#welcome').modal('show');},                             // callback when any board's item are clicked
        context          : function (el, event) {},                      // callback when any board's item are right clicked
        dragEl           : function (el, source) {},                     // callback when any board's item are dragged
        dragendEl        : function (el) {  },                             // callback when any board's item stop drag
        dropEl           : function (el, target, source, sibling) {},    // callback when any board's item drop in a board
        dragBoard        : function (el, source) {},                     // callback when any board stop drag
        dragendBoard     : function (el) {},                             // callback when any board stop drag
        buttonClick      : function(el, boardId) {$('#welcome').modal('show');},                     // callback when the board's button is clicked
        propagationHandlers: [],
    })
    let boardsList = [
        {
            "id"    : "1",               // id of the board
            "title" : "To Do",              // title of the board
            "item"  : [                           // item of this board
                {
                    "id"    : "lyk2yc49g",        // id of the item
                    "title" : "Register to Kancci ✅",
                },
                {
                    "id"    : "ietpjgby7",
                    "title" : "Log in to Kancci 👨‍💻"
                },
                {
                    "id"    : "n1tavh7hx",
                    "title" : "Build your first Kanban ! 🚀"
                },
                {
                    "id"    : "a0wmwtuvy",
                    "title" : "Invite your mates 🎉"
                }
            ],
        },
        {
            "id"    : "2",
            "title" : "Working",
            "item" : [
                {
                    "id"    : "qbsj5uxbg",
                    "title" : "Discovering kancci 🧐"
                }
            ],
        },
        {
            "id"    : "3",
            "title" : "Done",
            "item" : [
                {
                    "id"    : "j2nodv5wt",
                    "title" : "Come on Kancci app 🙋‍"
                }
            ],
        }
    ]
    Kanban.addBoards(boardsList);
    let elements = $('.kanban-board');
    elements = Array.from(elements); //convert to array
    elements.map(element => // map on kanban-boards to add edit button
        {
            let settingsBtn = document.createElement("button")
            settingsBtn.innerHTML = "📝";
            settingsBtn.setAttribute('onclick',"$('#welcome').modal('show');")
            settingsBtn.classList = "btn float-right";
            element.children[0].append(settingsBtn)
        }
    );
</script>
@yield('scripts')
</body>
</html>
