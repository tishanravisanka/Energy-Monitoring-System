@extends('layouts.master')

@section('content')


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Device List</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Starter Page</li>
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

                            <div class="row">
                                <form id="devices-form" action="{{ route('deviceNo') }}" method="POST">
                                    @csrf
                                    <input id="deviceNo" type="hidden" name="deviceNo" value="">
                                </form>
                                <div hidden>
                                    {{($i = 0)}}
                                </div>
                                @if ($i!= 0)
                                @foreach ( $devices as $devices )
                                <div class="col-lg-3 col-xs-6">
                                    <!-- small box -->
                                    <div class="small-box bg-green">
                                        <div class="inner">
                                            <h3>Device <sup style="font-size: 20px">{{$devices['device_name']}}</sup></h3>

                                            <span class="info-box-number"><small>Temprature
                                                </small>{{$deviceData[$i]->temperature}}&deg;C</span><br>
                                            <span class="info-box-number"><small>Humidity &emsp;
                                                </small>{{$deviceData[$i]->humidity}}%</span><br>
                                            <span class="info-box-number"><small>HeatIndex &ensp;
                                                </small>{{$deviceData[$i]->heatIndex}}%</span><br>
                                            <span class="info-box-number"><small>Voltage &emsp;&ensp;
                                                </small>{{$deviceData[$i]->voltage}}V</span><br>
                                            <span class="info-box-number"><small>Current &emsp; &nbsp;
                                                </small>{{$deviceData[$i]->current}}A</span><br>
                                            <span class="info-box-number"><small>Power &emsp;&emsp;
                                                </small>{{$deviceData[$i]->power}}kW</span><br>
                                            <span class="info-box-number"><small>Frequency &ensp;
                                                </small>{{$deviceData[$i++]->frequency}}Hz</span>

                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-tree"></i>
                                        </div>
                                        <a onclick="setDeviceId('{{$devices['device_name']}}')"
                                            class="small-box-footer roomlink">More info <i
                                                class="fa fa-arrow-circle-right"></i></a>


                                    </div>
                                </div>

                                @endforeach
                                @endif



                                @if ($i== 0)
                                <div class="error-content">
                                    <h3><i class="fa fa-warning text-yellow"></i> Oops! No Devices Available.</h3>
                                    <p>
                                        Please add a device!!!

                                    </p>
                                </div>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
                <!-- /.col-md-12 -->

            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>

<script>
    function setDeviceId(val) {
        
        document.getElementById('deviceNo').value = val;
        document.getElementById('devices-form').submit();
    }

</script>
@endsection
