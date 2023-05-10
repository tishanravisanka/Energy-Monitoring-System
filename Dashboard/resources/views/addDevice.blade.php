@extends('layouts.master')

@section('content')

<head>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="css/adminlte.min.css">
    <style>
        .tooltip {
            position: absolute;
            z-index: 1070;
            display: block;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 12px;
            font-style: normal;
            font-weight: 400;
            line-height: 1.42857143;
            text-align: left;
            text-align: start;
            text-decoration: none;
            text-shadow: none;
            text-transform: none;
            letter-spacing: normal;
            word-break: normal;
            word-spacing: normal;
            word-wrap: normal;
            white-space: normal;
            filter: alpha(opacity=0);
            opacity: 0;
            line-break: auto
        }

        .tooltip.in {
            filter: alpha(opacity=90);
            opacity: .9
        }

        .tooltip.top {
            padding: 5px 0;
            margin-top: -3px
        }

        .tooltip-arrow {
            position: absolute;
            width: 0;
            height: 0;
            border-color: transparent;
            border-style: solid
        }

        .tooltip.top .tooltip-arrow {
            bottom: 0;
            left: 50%;
            margin-left: -5px;
            border-width: 5px 5px 0;
            border-top-color: #000
        }

    </style>
</head>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    @if(session('error'))
    <div class="alert alert-danger">
        {{session('error')}}
    </div>
    @endif

    @if(session('success'))
    <div class="alert alert-success">
        {{session('success')}}
    </div>
    @endif


    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
            <li> {{$error}} </li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Add Device</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="home">Home</a></li>
                        <li class="breadcrumb-item active">Add Device</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">

                            @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                            @endif
                            <form class="form-horizontal" method="POST" action="{{ route('addDeviceData') }}">
                                @csrf

                                <div class="box-body">
                                    <div class="form-group row">
                                        <label for="deviceId" class="col-sm-2 control-label" data-toggle="tooltip"
                                            data-placement="top" title="Id of provided device">Device ID</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="deviceId"
                                                placeholder="Device ID" required>
                                        </div>

                                    </div>

                                    <div class="form-group row">
                                        <label for="temperature" class="col-sm-2 control-label" data-toggle="tooltip"
                                            data-placement="top"
                                            title="Set minimum temperature value. In case of anomaly you will be notified">Min
                                            Temperature</label>

                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="minTemperature"
                                                placeholder="Min Temperature in Celsius" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="temperature" class="col-sm-2 control-label" data-toggle="tooltip"
                                            data-placement="top"
                                            title="Set maximum temperature value. In case of anomaly you will be notified">Max
                                            Temperature</label>

                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="maxTemperature"
                                                placeholder="Max Temperature in Celsius" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="humidity" class="col-sm-2 control-label" data-toggle="tooltip"
                                            data-placement="top"
                                            title="Set minimum humidity value. In case of anomaly you will be notified">Min
                                            Humidity</label>

                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="minHumidity"
                                                placeholder="Min Humidity Percentage" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="humidity" class="col-sm-2 control-label" data-toggle="tooltip"
                                            data-placement="top"
                                            title="Set maximum humidity value. In case of anomaly you will be notified">Max
                                            Humidity</label>

                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="maxHumidity"
                                                placeholder="Max Humidity Percentage" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="voltage" class="col-sm-2 control-label" data-toggle="tooltip"
                                            data-placement="top"
                                            title="Set minimum voltage value. In case of anomaly you will be notified">Min
                                            Voltage</label>

                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="minVoltage"
                                                placeholder="Min Voltage" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="voltage" class="col-sm-2 control-label" data-toggle="tooltip"
                                            data-placement="top"
                                            title="Set maximum voltage value. In case of anomaly you will be notified">Max
                                            Voltage</label>

                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="maxVoltage"
                                                placeholder="Max Voltage" required>
                                        </div>
                                    </div>


                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer">

                                    <button type="submit" class="btn btn-info pull-right">Add</button>
                                </div>
                                <!-- /.box-footer -->
                            </form>


                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip({
            'placement': 'top'
        });
    });

</script>

@endsection
