@extends('layouts.master')

@section('content')

<head>
    <title>Device Data</title>

    {{-- data table --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css" rel="stylesheet"
        id="bootstrap-css">
    <link href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css" rel="stylesheet"
        id="bootstrap-css">
    <link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.bootstrap4.min.css" rel="stylesheet"
        id="bootstrap-css">

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.colVis.min.js"></script>
    {{-- data table --}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/paho-mqtt/1.0.1/mqttws31.js" type="text/javascript"></script>

    <script type="text/javascript">
        function onConnectionLost() {
            connected_flag = 0;
        }

        function onFailure(message) {
            setTimeout(MQTTconnect, reconnectTimeout);
        }

        function onMessageArrived(r_message) {
            out_msg = "Message received " + r_message.payloadString + "<br>";
            out_msg = out_msg + "Message received Topic " + r_message.destinationName;
            console.log(out_msg);
        }

        function onConnect() {
            connected_flag = 1
        }

        function MQTTconnect() {
            if (connected_flag == 1) {
                return false;
            }

            var x = Math.floor(Math.random() * 10000);
            var cname = "orderform-" + x;
            mqtt = new Paho.MQTT.Client("broker.mqttdashboard.com", 8000, cname);
            var options = {
                timeout: 3,
                onSuccess: onConnect,
                onFailure: onFailure,

            };

            mqtt.onConnectionLost = onConnectionLost;
            mqtt.onMessageArrived = onMessageArrived;

            mqtt.connect(options);
            // return false;

        }

    </script>



    {{-- date time picker --}}
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">

    {{-- date time picker --}}

</head>
<script>
    var connected_flag = 0
    var mqtt;
    var reconnectTimeout = 2000;
    var host = "broker.mqttdashboard.com";
    var port = 8000;

</script>

<div class="content-wrapper">
    <div class="content-header">

        <div class="container-fluid">
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif
            <div class="row">

                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">
                                Device_{{ $deviceNo }}</h3>
                            <input class="form-control float-right" name="deviceNoVal" id="deviceNoVal"
                                value="{{ $deviceNo }}" hidden>
                        </div>
                        <div class="card-body">
                            <div style="margin: 10px" class="row">


                                <div class="row" style="width: 50%">
                                    <div class="col-lg-3 col-xs-6">
                                        Machine 1
                                    </div>
                                    <div>
                                        <button id="machine1OnBtn" type="button" class="btn btn-success btn-xs"
                                            onclick="machine1On();">ON
                                            &nbsp;</button><br>
                                        <button type="button" class="btn btn-danger btn-xs"
                                            onclick="machine1Off();">OFF&nbsp;</button>
                                    </div>
                                </div>
                                <div class="row" style="width: 50%">
                                    <div class="col-lg-3 col-xs-6">
                                        Machine 2
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-success btn-xs" onclick="machine2On();">ON
                                            &nbsp;</button><br>
                                        <button type="button" class="btn btn-danger btn-xs"
                                            onclick="machine2Off();">OFF&nbsp;</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card card-primary">

                        <div class="card-body">

                            <div class="form-group">
                                <label>Date range:</label>

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control float-right" name="dateRange" id="dateRange">
                                </div>
                                <!-- /.input group -->
                            </div>
                            <!-- /.form group -->

                            <div class="box-footer">
                                <button id="searchBtn" class="btn btn-info pull-right">Search</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-body">
                    <div id="chartContainerTemprature" style="height: 300px; max-width: 920px; margin: 0px auto;"></div>
                    <br>
                    <div id="chartContainerHumidity" style="height: 300px; max-width: 920px; margin: 0px auto;"></div>
                    <br>
                    <div id="chartContainerHeatIndex" style="height: 300px; max-width: 920px; margin: 0px auto;"></div>
                    <br>
                    <div id="chartContainerVoltage" style="height: 300px; max-width: 920px; margin: 0px auto;"></div>
                    <div id="chartContainerCurrent" style="height: 300px; max-width: 920px; margin: 0px auto;"></div>
                    <div id="chartContainerPower" style="height: 300px; max-width: 920px; margin: 0px auto;"></div>
                    <div id="chartContainerFrequency" style="height: 300px; max-width: 920px; margin: 0px auto;"></div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Device Data</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="tempTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Temprature</th>
                                <th>Humidity</th>
                                <th>HeatIndex</th>
                                <th>Voltage</th>
                                <th>Current</th>
                                <th>Power</th>
                                <th>Frequency</th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Temprature</th>
                                <th>Humidity</th>
                                <th>HeatIndex</th>
                                <th>Voltage</th>
                                <th>Current</th>
                                <th>Power</th>
                                <th>Frequency</th>
                            </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
        </div>
        <!-- /.card -->

    </div>
    <!-- /.container-fluid -->
</div>


<script src="{{ asset('js/canvasjs.min.js') }}"></script>



{{-- ---------------------for date time picker---------------------------- --}}
<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

<!-- InputMask -->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/inputmask/jquery.inputmask.min.js') }}"></script>

<!-- date-range-picker -->
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>

<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>

{{-- ---------------------for date time picker---------------------------- --}}

<script>
    $(function () {

        //Date range picker
        $('#reservationdate').datetimepicker({
            format: 'L'
        });

        //Date range picker
        $('#dateRange').daterangepicker()
        //Date range picker with time picker
        $('#dateTimeRange').daterangepicker({
            timePicker: true,
            timePickerIncrement: 30,
            locale: {
                format: 'MM/DD/YYYY hh:mm A'
            }
        })

    })

</script>
<script type="text/javascript">
    MQTTconnect();

</script>

<script>
    function machine1On() {
        if (connected_flag == 0) {
            MQTTconnect();
        }
        message = new Paho.MQTT.Message("1");
        message.destinationName = "data/energy/1/machine1";
        mqtt.send(message);

    }

    function machine1Off() {
        if (connected_flag == 0) {
            MQTTconnect();
        }
        message = new Paho.MQTT.Message("0");
        message.destinationName = "data/energy/1/machine1";
        mqtt.send(message);

    }

    function machine2On() {
        if (connected_flag == 0) {
            MQTTconnect();
        }
        message = new Paho.MQTT.Message("1");
        message.destinationName = "data/energy/1/machine2";
        mqtt.send(message);

    }

    function machine2Off() {
        if (connected_flag == 0) {
            MQTTconnect();
        }
        message = new Paho.MQTT.Message("0");
        message.destinationName = "data/energy/1/machine2";
        mqtt.send(message);

    }

</script>

<script>
    var chartDataTemprature = [];
    var chartDataHumidity = [];
    var chartDataHeatIndex = [];
    var chartDataVoltage = [];
    var chartDataCurrent = [];
    var chartDataPower = [];
    var chartDataFrequency = [];
    var tableData = [];
    var myData = {
        deviceNo: document.getElementById("deviceNoVal").value,
    }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "{{ route('receiveDeviceData') }}",
        method: "GET",
        data: myData,
        success: function (data) {
            console.log(data);

            var unitChartTemprature = {};
            var unitChartHumidity = {};
            var unitChartHeatIndex = {};
            var unitChartVoltage = {};
            var unitChartCurrent = {};
            var unitChartPower = {};
            var unitChartFrequency = {};
            var unitTable = {};

            chartDataTemprature = JSON.stringify(chartDataTemprature);
            chartDataHumidity = JSON.stringify(chartDataHumidity);
            chartDataHeatIndex = JSON.stringify(chartDataHeatIndex);
            chartDataVoltage = JSON.stringify(chartDataVoltage);
            chartDataCurrent = JSON.stringify(chartDataCurrent);
            chartDataPower = JSON.stringify(chartDataPower);
            chartDataFrequency = JSON.stringify(chartDataFrequency);
            tableData = JSON.stringify(tableData);

            $.each(data, function (key, value) {

                chartDataTemprature = JSON.parse(chartDataTemprature);
                chartDataHumidity = JSON.parse(chartDataHumidity);
                chartDataHeatIndex = JSON.parse(chartDataHeatIndex);
                chartDataVoltage = JSON.parse(chartDataVoltage);
                chartDataCurrent = JSON.parse(chartDataCurrent);
                chartDataPower = JSON.parse(chartDataPower);
                chartDataFrequency = JSON.parse(chartDataFrequency);
                tableData = JSON.parse(tableData);

                var fixedDate = new Date(value.created_at.slice(0, 4), value.created_at.slice(5,
                        7) - 1, value.created_at.slice(8, 10), value.created_at.slice(11, 13),
                    value
                    .created_at.slice(14, 16), value.created_at.slice(17, 19));
                var time = fixedDate.getTime();

                unitTable["Date"] = value.created_at.slice(0, 10);
                unitTable["Time"] = value.created_at.slice(11, 19);
                unitTable["Temprature"] = value.temperature;
                unitTable["Humidity"] = value.humidity;
                unitTable["HeatIndex"] = value.heatIndex;
                unitTable["Voltage"] = value.voltage;
                unitTable["Current"] = value.current;
                unitTable["Power"] = value.power;
                unitTable["Frequency"] = value.frequency;
                tableData.push(unitTable);

                unitChartTemprature["x"] = time;
                unitChartTemprature["y"] = parseInt(value.temperature);
                chartDataTemprature.push(unitChartTemprature);

                unitChartHumidity["x"] = time;
                unitChartHumidity["y"] = parseInt(value.humidity);
                chartDataHumidity.push(unitChartHumidity);

                unitChartHeatIndex["x"] = time;
                unitChartHeatIndex["y"] = parseInt(value.heatIndex);
                chartDataHeatIndex.push(unitChartHeatIndex);

                unitChartVoltage["x"] = time;
                unitChartVoltage["y"] = parseInt(value.voltage);
                chartDataVoltage.push(unitChartVoltage);

                unitChartCurrent["x"] = time;
                unitChartCurrent["y"] = parseInt(value.current);
                chartDataCurrent.push(unitChartCurrent);

                unitChartPower["x"] = time;
                unitChartPower["y"] = parseInt(value.power);
                chartDataPower.push(unitChartPower);

                unitChartFrequency["x"] = time;
                unitChartFrequency["y"] = parseInt(value.frequency);
                chartDataFrequency.push(unitChartFrequency);

                chartDataTemprature = JSON.stringify(chartDataTemprature);
                chartDataHumidity = JSON.stringify(chartDataHumidity);
                chartDataHeatIndex = JSON.stringify(chartDataHeatIndex);
                chartDataVoltage = JSON.stringify(chartDataVoltage);
                chartDataCurrent = JSON.stringify(chartDataCurrent);
                chartDataPower = JSON.stringify(chartDataPower);
                chartDataFrequency = JSON.stringify(chartDataFrequency);
                tableData = JSON.stringify(tableData);

            });

            chartDataTemprature = JSON.parse(chartDataTemprature);
            chartDataHumidity = JSON.parse(chartDataHumidity);
            chartDataHeatIndex = JSON.parse(chartDataHeatIndex);
            chartDataVoltage = JSON.parse(chartDataVoltage);
            chartDataCurrent = JSON.parse(chartDataCurrent);
            chartDataPower = JSON.parse(chartDataPower);
            chartDataFrequency = JSON.parse(chartDataFrequency);
            tableData = JSON.parse(tableData);
            console.log(tableData);


        },
        error: function () {
            console.log(data);
        },
        async: false
    });

    $(function () {

    });



    window.onload = function () {

        var table = $("#tempTable").DataTable({
            data: tableData,
            "responsive": true,
            "lengthChange": false,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': true,
            "columns": [{
                    "data": "Date"
                },
                {
                    "data": "Time"
                },
                {
                    "data": "Temprature"
                },
                {
                    "data": "Humidity"
                },
                {
                    "data": "HeatIndex"
                },
                {
                    "data": "Voltage"
                },
                {
                    "data": "Current"
                },
                {
                    "data": "Power"
                },
                {
                    "data": "Frequency"
                },

            ],
            "buttons": ["csv", "excel", "pdf", "print"]

        }).buttons().container().appendTo('#tempTable_wrapper .col-md-6:eq(0)');



        var chartTemprature = new CanvasJS.Chart("chartContainerTemprature", {
            zoomEnabled: true,

            title: {
                text: "Temprature Data"
            },

            data: [{
                type: "area",
                xValueType: "dateTime",
                dataPoints: chartDataTemprature,

            }]
        });
        chartTemprature.render();

        var chartHumidity = new CanvasJS.Chart("chartContainerHumidity", {
            zoomEnabled: true,

            title: {
                text: "Humidity Data"
            },

            data: [{
                type: "area",
                xValueType: "dateTime",
                dataPoints: chartDataHumidity,

            }]
        });
        chartHumidity.render();

        var chartHeatIndex = new CanvasJS.Chart("chartContainerHeatIndex", {
            zoomEnabled: true,

            title: {
                text: "HeatIndex Data"
            },

            data: [{
                type: "area",
                xValueType: "dateTime",
                dataPoints: chartDataHeatIndex,

            }]
        });
        chartHeatIndex.render();

        var chartVoltage = new CanvasJS.Chart("chartContainerVoltage", {
            zoomEnabled: true,

            title: {
                text: "Voltage Data"
            },

            data: [{
                type: "area",
                xValueType: "dateTime",
                dataPoints: chartDataVoltage,

            }]
        });
        chartVoltage.render();

        var chartCurrent = new CanvasJS.Chart("chartContainerCurrent", {
            zoomEnabled: true,

            title: {
                text: "Current Data"
            },

            data: [{
                type: "area",
                xValueType: "dateTime",
                dataPoints: chartDataCurrent,

            }]
        });
        chartCurrent.render();

        var chartPower = new CanvasJS.Chart("chartContainerPower", {
            zoomEnabled: true,

            title: {
                text: "Power Data"
            },

            data: [{
                type: "area",
                xValueType: "dateTime",
                dataPoints: chartDataPower,

            }]
        });
        chartPower.render();

        var chartFrequency = new CanvasJS.Chart("chartContainerFrequency", {
            zoomEnabled: true,

            title: {
                text: "Frequency Data"
            },

            data: [{
                type: "area",
                xValueType: "dateTime",
                dataPoints: chartDataFrequency,

            }]
        });
        chartFrequency.render();




        $("#searchBtn").click(function () {

            chartDataTemprature = [];
            var chartDataHumidity = [];
            var chartDataHeatIndex = [];
            var chartDataVoltage = [];
            var chartDataCurrent = [];
            var chartDataPower = [];
            var chartDataFrequency = [];
            tableData = [];
            var myData = {
                deviceNo: document.getElementById("deviceNoVal").value,
                dateRange: document.getElementById("dateRange").value
            }
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('receiveDeviceData') }}",
                method: "GET",
                data: myData,
                success: function (data) {

                    var unitChartTemprature = {};
                    var unitChartHumidity = {};
                    var unitChartHeatIndex = {};
                    var unitChartVoltage = {};
                    var unitChartCurrent = {};
                    var unitChartPower = {};
                    var unitChartFrequency = {};
                    var unitTable = {};

                    chartDataTemprature = JSON.stringify(chartDataTemprature);
                    chartDataHumidity = JSON.stringify(chartDataHumidity);
                    chartDataHeatIndex = JSON.stringify(chartDataHeatIndex);
                    chartDataVoltage = JSON.stringify(chartDataVoltage);
                    chartDataCurrent = JSON.stringify(chartDataCurrent);
                    chartDataPower = JSON.stringify(chartDataPower);
                    chartDataFrequency = JSON.stringify(chartDataFrequency);
                    tableData = JSON.stringify(tableData);

                    $.each(data, function (key, value) {

                        chartDataTemprature = JSON.parse(chartDataTemprature);
                        chartDataHumidity = JSON.parse(chartDataHumidity);
                        chartDataHeatIndex = JSON.parse(chartDataHeatIndex);
                        chartDataVoltage = JSON.parse(chartDataVoltage);
                        chartDataCurrent = JSON.parse(chartDataCurrent);
                        chartDataPower = JSON.parse(chartDataPower);
                        chartDataFrequency = JSON.parse(chartDataFrequency);
                        tableData = JSON.parse(tableData);

                        var fixedDate = new Date(value.created_at.slice(0, 4), value
                            .created_at.slice(5, 7) - 1, value.created_at.slice(8,
                                10), value.created_at.slice(11, 13), value
                            .created_at.slice(14, 16), value.created_at.slice(17,
                                19));
                        var time = fixedDate.getTime();

                        unitTable["Date"] = value.created_at.slice(0, 10);
                        unitTable["Time"] = value.created_at.slice(11, 19);
                        unitTable["Temprature"] = value.temperature;
                        unitTable["Humidity"] = value.humidity;
                        unitTable["HeatIndex"] = value.heatIndex;
                        unitTable["Voltage"] = value.voltage;
                        unitTable["Current"] = value.current;
                        unitTable["Power"] = value.power;
                        unitTable["Frequency"] = value.frequency;
                        tableData.push(unitTable);

                        unitChartTemprature["x"] = time;
                        unitChartTemprature["y"] = parseInt(value.temperature);
                        chartDataTemprature.push(unitChartTemprature);

                        unitChartHumidity["x"] = time;
                        unitChartHumidity["y"] = parseInt(value.humidity);
                        chartDataHumidity.push(unitChartHumidity);

                        unitChartHeatIndex["x"] = time;
                        unitChartHeatIndex["y"] = parseInt(value.heatIndex);
                        chartDataHeatIndex.push(unitChartHeatIndex);

                        unitChartVoltage["x"] = time;
                        unitChartVoltage["y"] = parseInt(value.voltage);
                        chartDataVoltage.push(unitChartVoltage);

                        unitChartCurrent["x"] = time;
                        unitChartCurrent["y"] = parseInt(value.current);
                        chartDataCurrent.push(unitChartCurrent);

                        unitChartPower["x"] = time;
                        unitChartPower["y"] = parseInt(value.power);
                        chartDataPower.push(unitChartPower);

                        unitChartFrequency["x"] = time;
                        unitChartFrequency["y"] = parseInt(value.frequency);
                        chartDataFrequency.push(unitChartFrequency);

                        chartDataTemprature = JSON.stringify(chartDataTemprature);
                        chartDataHumidity = JSON.stringify(chartDataHumidity);
                        chartDataHeatIndex = JSON.stringify(chartDataHeatIndex);
                        chartDataVoltage = JSON.stringify(chartDataVoltage);
                        chartDataCurrent = JSON.stringify(chartDataCurrent);
                        chartDataPower = JSON.stringify(chartDataPower);
                        chartDataFrequency = JSON.stringify(chartDataFrequency);
                        tableData = JSON.stringify(tableData);

                    });

                    chartDataTemprature = JSON.parse(chartDataTemprature);
                    chartDataHumidity = JSON.parse(chartDataHumidity);
                    chartDataHeatIndex = JSON.parse(chartDataHeatIndex);
                    chartDataVoltage = JSON.parse(chartDataVoltage);
                    chartDataCurrent = JSON.parse(chartDataCurrent);
                    chartDataPower = JSON.parse(chartDataPower);
                    chartDataFrequency = JSON.parse(chartDataFrequency);
                    tableData = JSON.parse(tableData);

                    console.log(chartDataTemprature);
                    console.log(chartDataHumidity);
                    console.log(chartDataHeatIndex);
                    console.log(chartDataVoltage);
                    console.log(chartDataCurrent);
                    console.log(chartDataPower);
                    console.log(chartDataFrequency);
                },
                error: function () {
                    console.log(data);
                },
                async: false
            });

            chartTemprature.options.data[0].dataPoints = chartDataTemprature;
            chartTemprature.render();

            chartHumidity.options.data[0].dataPoints = chartDataHumidity;
            chartHumidity.render();

            chartHeatIndex.options.data[0].dataPoints = chartDataHeatIndex;
            chartHeatIndex.render();

            chartVoltage.options.data[0].dataPoints = chartDataVoltage;
            chartVoltage.render();

            chartCurrent.options.data[0].dataPoints = chartDataCurrent;
            chartCurrent.render();

            chartPower.options.data[0].dataPoints = chartDataPower;
            chartPower.render();

            chartFrequency.options.data[0].dataPoints = chartDataFrequency;
            chartFrequency.render();

            table = $('#tempTable').DataTable();
            table.clear().draw();
            table.rows.add(tableData); // Add new data
            table.columns.adjust().draw(); // Redraw the DataTable


        });
    }

</script>



<script>
    function myFunction() {
        document.getElementById("searchBtn").click(); // Click on the search
    }

    // refresh data in every 20 seconds
    $(document).ready(function () {

        setInterval(myFunction, 20000);

    });

</script>


@endsection
