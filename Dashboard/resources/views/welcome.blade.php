@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">

<title>PlantVezel</title>

<!-- Fonts -->
<link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">



</head>

<body class="hold-transition lockscreen">



    <!-- Automatic element centering -->
    <div class="lockscreen-wrapper">
        <div class="lockscreen-logo">
            <a href="#">Power<b>C</b></a>
        </div>
        <!-- User name -->
        <div class="lockscreen-name"></div>

        <!-- START LOCK SCREEN ITEM -->
        <div class="lockscreen-item">
            <!-- lockscreen image -->
            <div class="lockscreen-image">
                <img src="../img/logo.png" alt="User Image">
            </div>
            <!-- /.lockscreen-image -->

            <!-- lockscreen credentials (contains the form) -->

            <div class="input-group">

                <label type="button" class="btn btn-flat"> </label>
                <div class="input-group-btn">
                    <button type="button" class="btn"><i class="fa fa-tree text-muted"></i></button>
                </div>
            </div>

            <!-- /.lockscreen credentials -->

        </div>
        <!-- /.lockscreen-item -->
        <div class="help-block text-center">
            IoT Energy monitoring and Machine Controling System
        </div>

        <div class="lockscreen-footer text-center">
            Copyright &copy; 2022 <b><a href="#" class="text-black">PowerC</a></b><br>
            All rights reserved
        </div>
    </div>
    <!-- /.center -->

    <!-- jQuery 3 -->
    <script src="../../bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    </div>
</body>


@endsection
