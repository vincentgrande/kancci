<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>KANCCI - @yield('title')</title>
    <link rel="shortcut icon" href="{{asset('favicon.ico') }}" type="image/x-icon"/>
    <link href="{{asset('css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/jkanban.min.css')}}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="{{asset('css/sb-admin-2.css')}}" rel="stylesheet">
</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-dark sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('index') }}">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fab fa-trello"></i>
            </div>
            <div id="main-logo" class="sidebar-brand-text mx-3">KANCCI</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
            <a class="nav-link" href="{{ route('index') }}">
                <i class="fas fa-users"></i>
                <span>Your workgroups</span></a>
        </li>
        <!-- Divider -->
        <hr class="sidebar-divider">

        @yield('actions')


        <div class="fixed-bottom">
             <!-- Divider -->
            <hr class="sidebar-divider">
            <li class="nav-item active">
                <a class="nav-link" href="#">
                    <i class="fas fa-file-alt"></i>
                    <span>Documentation</span></a>
            </li>
        </div>
    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content" class="bg-gray">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-primary topbar mb-4 static-top shadow">

                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3 bg-light">
                    <i class="fa fa-bars"></i>
                </button>

                <!-- Topbar Search -->
                <form
                    class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                    <div class="input-group">
                        <input id="searchTextField" name="searchTextField" type="text" class="form-control bg-light border-0 small text-dark" placeholder="Search for..."
                               aria-label="Search" aria-describedby="basic-addon2" onfocusout="hide()" onfocusin="show()" onkeyup="SearchFieldEvent()" autocomplete="off">
                        <div class="input-group-append">
                            <button class="btn btn-dark" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                    <ul class="bg-light text-dark" style="padding-left: 0;" id="searchResult" onfocusout="hide()"></ul>
                </form>

                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                    <li class="nav-item dropdown no-arrow d-sm-none">
                        <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="$('#searchDropdown').dropdown('toggle');">
                            <i class="fas fa-search fa-fw"></i>
                        </a>
                        <!-- Dropdown - Messages -->
                        <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                             aria-labelledby="searchDropdown">
                            <form class="form-inline mr-auto w-100 navbar-search">
                                <div class="input-group">
                                    <input type="text" class="form-control bg-light border-0 small"
                                           placeholder="Search for..." aria-label="Search"
                                           aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button class="btn btn-light" type="button">
                                            <i class="fas fa-search fa-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </li>

                    <!-- Nav Item - Alerts -->
                    <li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="$('#alertsDropdown').dropdown('toggle');">
                            <i class="fas fa-bell fa-fw"></i>
                            <!-- Counter - Alerts -->

                            <span id="badge" class="badge badge-danger badge-counter"></span>
                        </a>
                        <!-- Dropdown - Alerts -->
                        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                             aria-labelledby="alertsDropdown">
                            <h6 class="dropdown-header">
                                Alerts Center
                            </h6>
                            <div id="alertList">

                            </div>

                        </div>
                    </li>

                    <div class="topbar-divider d-none d-sm-block"></div>

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="$('#userDropdown').dropdown('toggle');">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::check() ? ucfirst(trans(Auth::user()->name)) : 'Guest'  }}</span>
                            <img class="img-profile rounded-circle"
                                 src="{{asset('img/'.Auth::user()->picture)}}">
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                             aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="{{route('settingsProfileGet')}}">
                                <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                Settings
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal" onclick="$('#logoutModal').modal('show');">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                        </div>
                    </li>

                </ul>

            </nav>
            <!-- End of Topbar -->
            <!-- Begin Page Content -->
            <div id="container-body" class="container-fluid">
                <!-- Content Row -->
                <div class="row text-dark">
                    @yield('content')
                </div>
            </div>

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-primary">
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


<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close" onclick="$('#logoutModal').modal('hide');">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body text-dark">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="button" data-dismiss="modal" onclick="$('#logoutModal').modal('hide');">Cancel</button>
                <a class="btn btn-danger" href="{{route("logout")}}"
                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('js/app.js')}}"></script>
<script src="{{asset('js/jquery.min.js')}}"></script>
<script>
    let getAlert = function(){
        $.ajax({
            url: "{{ route('getAlert') }}",
            method: 'get',
            data: {
            },
            success: function (result) {
                if(result !== "0"){
                    document.getElementById('badge').innerHTML = result.length + "+"
                    result.map(x => {
                        $('#alertList').append(`
                                        <a class="dropdown-item d-flex align-items-center alerte" href="#">
                                        <div class="mr-3">
                                            <div class="icon-circle bg-warning">
                                                <i class="fas fa-exclamation-triangle text-white"></i>
                                            </div>
                                        </div>
                                        <div class="position-relative">
                                            <div class="small text-danger"> End date :  `+x.card.endDate+`</div>
                                            `+x.card.title+`
                                            <button class="btn btn-danger btn-sm " onclick='readAlert(`+x.id+`)'><i class="fas fa-times"></i></button>
                                        </div>
                                    </a>
                                        `)
                    })
                }
            }
        })
    }

    let readAlert = function(id){
        $.ajax({
            url: "{{ route('readAlert') }}",
            method: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                id: id
            },
            success: function (result) {
                $('#alertList').empty()
                getAlert()
            }
        })
    }
    getAlert()



</script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
<script src='{{asset('js/jkanban.min.js')}}'></script>
<script src="{{asset('js/sb-admin-2.min.js')}}"></script>
<script>
    function SearchFieldEvent() {
        let search = $("#searchTextField").val();
        let ul = $("#searchResult");
        if (search !== "") {
            $.ajax({
                url: '{{ route('Search') }}',
                method: 'get',
                data: {'search': search},
                success: function(result) {
                    ul.empty();
                    ul.show(100);
                    ul.append('<br/>');
                    ul.append('<a style="padding-left: 10rem">Workgroups</a>');
                    ul.append('<br/>');
                    result['workgroups'].forEach(x => {
                        ul.append('<a href="/workgroup/'+ x.id +'"><input type="button" class="form-control bg-light w-100 mb-1" value="'+ x.title +'"/></a>');
                    });
                    ul.append('<hr>');
                    ul.append('<a style="padding-left: 11rem">Kanbans</a>');
                    ul.append('<br/>');
                    result['kanbans'].forEach(x => {
                        ul.append('<a href="/kanban/'+ x.id +'"><input type="button" class="form-control bg-light w-100 mb-1" value="'+ x.title +'"/></a>');
                    });

                }
            });
        }
    }

    function setUpLink(nid)
    {
        window.location.href= "/workgroup/" + nid;
    }
    function hide() {
        setTimeout(() => {$("#searchResult").hide(100); }, 200);
    }
    function show() {
        $("#searchResult").show(100);
    }
    </script>
@yield('scripts')
</body>
</html>
