@extends('layouts.master')


<head>
    <title>Device List</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <style>
        body {
            color: #566787;
            background: #f5f5f5;
            font-family: 'Varela Round', sans-serif;
            font-size: 13px;
        }

        .table-responsive {
            margin: 30px 0;
        }

        .table-wrapper {
            background: #fff;
            padding: 20px 25px;
            border-radius: 3px;
            min-width: 1000px;
            box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
        }

        .table-title {
            padding-bottom: 15px;
            background: #435d7d;
            color: #fff;
            padding: 16px 30px;
            min-width: 100%;
            margin: -20px -25px 10px;
            border-radius: 3px 3px 0 0;
        }

        .table-title h2 {
            margin: 5px 0 0;
            font-size: 24px;
        }

        .table-title .btn-group {
            float: right;
        }

        .table-title .btn {
            color: #fff;
            float: right;
            font-size: 13px;
            border: none;
            min-width: 50px;
            border-radius: 2px;
            border: none;
            outline: none !important;
            margin-left: 10px;
        }

        .table-title .btn i {
            float: left;
            font-size: 21px;
            margin-right: 5px;
        }

        .table-title .btn span {
            float: left;
            margin-top: 2px;
        }

        table.table tr th,
        table.table tr td {
            border-color: #e9e9e9;
            padding: 12px 15px;
            vertical-align: middle;
        }

        table.table tr th:first-child {
            width: 60px;
        }

        table.table tr th:last-child {
            width: 100px;
        }

        table.table-striped tbody tr:nth-of-type(odd) {
            background-color: #fcfcfc;
        }

        table.table-striped.table-hover tbody tr:hover {
            background: #f5f5f5;
        }

        table.table th i {
            font-size: 13px;
            margin: 0 5px;
            cursor: pointer;
        }

        table.table td:last-child i {
            opacity: 0.9;
            font-size: 22px;
            margin: 0 5px;
        }

        table.table td a {
            font-weight: bold;
            color: #566787;
            display: inline-block;
            text-decoration: none;
            outline: none !important;
        }

        table.table td a:hover {
            color: #2196F3;
        }

        table.table td a.edit {
            color: #FFC107;
        }

        table.table td a.delete {
            color: #F44336;
        }

        table.table td i {
            font-size: 19px;
        }

        table.table .avatar {
            border-radius: 50%;
            vertical-align: middle;
            margin-right: 10px;
        }

        .pagination {
            float: right;
            margin: 0 0 5px;
        }

        .pagination li a {
            border: none;
            font-size: 13px;
            min-width: 30px;
            min-height: 30px;
            color: #999;
            margin: 0 2px;
            line-height: 30px;
            border-radius: 2px !important;
            text-align: center;
            padding: 0 6px;
        }

        .pagination li a:hover {
            color: #666;
        }

        .pagination li.active a,
        .pagination li.active a.page-link {
            background: #03A9F4;
        }

        .pagination li.active a:hover {
            background: #0397d6;
        }

        .pagination li.disabled i {
            color: #ccc;
        }

        .pagination li i {
            font-size: 16px;
            padding-top: 6px
        }

        .hint-text {
            float: left;
            margin-top: 10px;
            font-size: 13px;
        }

        /* Modal styles */
        .modal .modal-dialog {
            max-width: 400px;
        }

        .modal .modal-header,
        .modal .modal-body,
        .modal .modal-footer {
            padding: 20px 30px;
        }

        .modal .modal-content {
            border-radius: 3px;
            font-size: 14px;
        }

        .modal .modal-footer {
            background: #ecf0f1;
            border-radius: 0 0 3px 3px;
        }

        .modal .modal-title {
            display: inline-block;
        }

        .modal .form-control {
            border-radius: 2px;
            box-shadow: none;
            border-color: #dddddd;
        }

        .modal textarea.form-control {
            resize: vertical;
        }

        .modal .btn {
            border-radius: 2px;
            min-width: 100px;
        }

        .modal form label {
            font-weight: normal;
        }


        .button {
            display: inline-block;
            border-radius: 4px;
            background-color: #f4511e;
            border: none;
            color: #FFFFFF;
            text-align: center;
            font-size: 14px;
            padding: 5px;
            width: 150px;
            transition: all 0.5s;
            cursor: pointer;
            margin: 5px;
        }

        .button span {
            cursor: pointer;
            display: inline-block;
            position: relative;
            transition: 0.5s;
        }

        .button span:after {
            content: '\00bb';
            position: absolute;
            opacity: 0;
            top: 0;
            right: -20px;
            transition: 0.5s;
        }

        .button:hover span {
            padding-right: 25px;
        }

        .button:hover span:after {
            opacity: 1;
            right: 0;
        }

    </style>
</head>


@section('content')

@if (session('status'))
<div class="alert alert-success" role="alert">
    {{ session('status') }}
</div>
@endif
<br>

<div>
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="content-wrapper">
                <div class="container-fluid">
                    {{-- displaying errors --}}
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


                    <div class="card">

                        <!-- /.card-header -->
                        <div class="card-body">



                            <div class="container">
                                <br />
                                <h3 align="center">Device List</h3>
                                <br />
                            </div>

                            <a href="addDevice"><button class="button" style="vertical-align:middle"
                                    type="button"><span>Add Device
                                    </span></button></a>


                            @csrf
                            <table id="editable" class="table table-striped table-hover">
                                {{-- class="table table-bordered table-striped col-sm-12 col-md-12" --}}
                                <thead>
                                    <tr>
                                        <th>Device Name</th>
                                        <th>Min Temperature</th>
                                        <th>Max Temperature</th>
                                        <th>Min Humidity</th>
                                        <th>Max Humidity</th>
                                        <th>Min Voltage</th>
                                        <th>Max Voltage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- <td>1</td>
                                    <td>tishan</td>
                                    <td>ravi</td>
                                    <td>male</td> --}}
                                    @foreach($data as $row)
                                    <tr>
                                        <td>{{ $row->deviceName }}</td>
                                        <td>{{ $row->minTemperature }}</td>
                                        <td>{{ $row->maxTemperature }}</td>
                                        <td>{{ $row->minHumidity }}</td>
                                        <td>{{ $row->maxHumidity }}</td>
                                        <td>{{ $row->minVoltage }}</td>
                                        <td>{{ $row->maxVoltage }}</td>
                                        <td class="row">
                                            <a href="#" onclick="setEditData({{ $row }})" class="edit"
                                                data-toggle="modal"><i class="material-icons" data-toggle="tooltip"
                                                    title="Edit">&#xE254;</i></a>
                                            <a href="#" onclick="setDeleteData({{ $row }})" class="delete"
                                                data-toggle="modal"><i class="material-icons" data-toggle="tooltip"
                                                    title="Delete">&#xE872;</i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div hidden>
                                <a href="#editEnviroment" id="clickingEdit" class="edit" data-toggle="modal"><i
                                        class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
                                <a href="#deleteEnviroment" id="clickingDelete" class="delete" data-toggle="modal"><i
                                        class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>

                            </div>


                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->

        </div>
    </div>
    <div id="editEnviroment" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('editDeviceList') }}">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Machine Environment</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <input type="text" class="form-control" name="action" value="edit" hidden>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="deviceId" data-toggle="tooltip" data-placement="top"
                                title="Id of provided device">Device ID</label>
                            <input type="text" class="form-control" name="deviceId" id="deviceId" value="0"
                                placeholder="Device ID" required>

                        </div>

                        <div class="form-group">
                            <label for="temperature" data-toggle="tooltip" data-placement="top"
                                title="Set minimum temperature value. In case of anomaly you will be notified">Min
                                Temperature</label>

                            <input type="text" class="form-control" name="minTemperature" id="minTemperature"
                                placeholder="Min Temperature in Celsius" required>
                        </div>
                        <div class="form-group">
                            <label for="temperature" data-toggle="tooltip" data-placement="top"
                                title="Set maximum temperature value. In case of anomaly you will be notified">Max
                                Temperature</label>

                            <input type="text" class="form-control" name="maxTemperature" id="maxTemperature"
                                placeholder="Max Temperature in Celsius" required>
                        </div>

                        <div class="form-group">
                            <label for="humidity" data-toggle="tooltip" data-placement="top"
                                title="Set minimum humidity value. In case of anomaly you will be notified">Min
                                Humidity</label>

                            <input type="text" class="form-control" name="minHumidity" id="minHumidity"
                                placeholder="Min Humidity Percentage" required>
                        </div>
                        <div class="form-group">
                            <label for="humidity" data-toggle="tooltip" data-placement="top"
                                title="Set maximum humidity value. In case of anomaly you will be notified">Max
                                Humidity</label>

                            <input type="text" class="form-control" name="maxHumidity" id="maxHumidity"
                                placeholder="Max Humidity Percentage" required>
                        </div>

                        <div class="form-group">
                            <label for="voltage" data-toggle="tooltip" data-placement="top"
                                title="Set minimum voltage value. In case of anomaly you will be notified">Min
                                Voltage</label>

                            <input type="text" class="form-control" name="minVoltage" id="minVoltage"
                                placeholder="Min Voltage" required>
                        </div>
                        <div class="form-group">
                            <label for="voltage" data-toggle="tooltip" data-placement="top"
                                title="Set maximum voltage value. In case of anomaly you will be notified">Max
                                Voltage</label>

                            <input type="text" class="form-control" name="maxVoltage" id="maxVoltage"
                                placeholder="Max Voltage" required>
                        </div>

                        <div class="modal-footer">
                            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                            <input type="submit" class="btn btn-info" value="Save">
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>




<!-- Delete Modal HTML -->
<div id="deleteEnviroment" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('editDeviceList') }}">
                @csrf
                <input type="text" class="form-control" name="action" value="delete" hidden>
                <input type="text" class="form-control" name="deviceIdDel" id="deviceIdDel" value="" required hidden>

                <div class="modal-header">
                    <h4 class="modal-title">Delete Employee</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete these Records?</p>
                    <p class="text-warning">This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                    <input type="submit" class="btn btn-danger" value="Delete">
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    function setEditData(data) {
        document.getElementById("clickingEdit").click();

        document.getElementById('deviceId').value = data['deviceName'];
        // document.getElementById('minTemperature').value = data['deviceName'];
        document.getElementById('minTemperature').value = data['minTemperature'];
        document.getElementById('maxTemperature').value = data['maxTemperature'];
        document.getElementById('minHumidity').value = data['minHumidity'];
        document.getElementById('maxHumidity').value = data['maxHumidity'];
        document.getElementById('minVoltage').value = data['minVoltage'];
        document.getElementById('maxVoltage').value = data['maxVoltage'];

    }

    function setDeleteData(data) {
        document.getElementById("clickingDelete").click();

        document.getElementById('deviceIdDel').value = data['deviceName'];
    }

</script>

@endsection
