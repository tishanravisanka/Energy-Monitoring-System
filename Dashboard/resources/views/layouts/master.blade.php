<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PowerC</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
{{-- 
    <style>
        .main-sidebar { background-color: #6b2e00ad !important }
    </style> --}}

</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="index3.html" class="nav-link">Home</a>
                </li>

            </ul>

        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-secondary elevation-4">
            <!-- Brand Logo -->
            <a href="home" class="brand-link">
                <img src="img/logo.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">PowerC</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="img/user.png" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                    </div>
                </div>


                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="home" class="nav-link {{Request::is('home') ? 'active' : ''}}">
                                {{-- <i class="nav-icon fas fa-th"></i> --}}
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Home
                                </p>
                            </a>
                        </li>
                        <li class="nav-item {{Request::is('addDevice')||Request::is('deviceNo') ? 'menu-open' : ''}}">
                            <a href="#" class="nav-link {{Request::is('deviceNo')||Request::is('addDevice') ? 'active' : ''}}">
                                <i class="nav-icon fas fa-tree"></i>
                                <p>
                                    Devices
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul  class="nav nav-treeview" data-id="hoo">
                                <span id="deviceList"></span>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="deviceList" class="nav-link {{Request::is('deviceList') ? 'active' : ''}}">
                                {{-- <i class="nav-icon fas fa-th"></i> --}}
                                <i class="nav-icon fa fa-table"></i>
                                <p>
                                    Device List
                                </p>
                            </a>
                        </li>

                        <br><br>
                        {{-- logout --}}
                        <li><a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">


                                <i class="fa fa-circle-o text-red"></i> <span>SignOut</span> </a>


                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <form id="devices-form" action="{{ route('deviceNo') }}" method="POST">
            @csrf
            <input id="deviceNo" type="hidden" name="deviceNo" value="">
        </form>
        <section>
            @yield('content')
        </section>


        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
            </div>
            <!-- Default to the left -->
            <strong>IoT Energy monitoring and Machine Controling System.</strong>
        </footer>
    </div>
    <!-- ./wrapper -->


</body>

    <!-- jQuery -->
    <script src="{{ asset('js/app.js') }}"></script>

<script>
    jQuery.noConflict( );

</script>




<script>

    addDevices();
    // get realtime notification
    function addDevices() {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('getDevices') }}",
            method: "GET",

            success: function (data) {
                console.log('data',data);

                // var i = 0;
                // window.alert("hi");
                var list = [];
                $.each(data, function (key, value) {
                    console.log('val',value);
                        // push html data dynamically
                        list.push(
                                    "<li onclick='setDeviceId(\"" +
                                    value.deviceName +"\");' class='nav-item'>"+
                                    "<a href='#' class='nav-link '>"+
                                        "<i class='far fa-circle nav-icon'></i>"+
                                        "<p>Device_"+value.deviceName+"</p>"+
                                    "</a>"+
                                "</li>"
                        );

                });

                list.push('<li class="nav-item">'+
                                    '<a href="{{'addDevice'}}" class="nav-link {{Request::is("addDevice") ? "active" : ""}}">'+
                                        '<i class="fa fa-plus  nav-icon"></i>'+
                                        '<p>Add Device</p>'+
                                    '</a>'+
                                '</li>');
                // // set notifications and count
                document.getElementById("deviceList").innerHTML = list.join(" ");

            },
            error: function () {
                console.log(data);
            }
        });
    }

    function setDeviceId(val) {

        document.getElementById('deviceNo').value=val;
        document.getElementById('devices-form').submit();
    }
</script>


</html>
