<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\Devices;
use App\Notifications;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //$devices = Devices::where('email',Auth  ::user()->email)->get();
      
        $URI = 'http://127.0.0.1:8080/api/v/device/getDeviceData/'.Auth ::user()->email.'';
        
        $client = new \GuzzleHttp\Client();
        $request = $client->get($URI);
        $response = $request->getBody()->getContents();
        $devices = json_decode($response,TRUE);
        //dd($devices);

        $deviceData = null;
        $i = 0;
        foreach($devices as $row){
            
            $deviceData[$i] = DB::table('device_'.$row->device_name)->orderBy('created_at', 'desc')->first();
           
            /*
            $URI = 'http://127.0.0.1:8080/api/v/device/getDeviceNoData/'.$row->device_name.'';
        
            $client = new \GuzzleHttp\Client();
            $request = $client->get($URI);
            $response = $request->getBody()->getContents();
            $json = json_decode($response);

            */

            if($deviceData[$i] == null){
                // $deviceData[$i] = array('temperature' => 'NA', 'moisture' => 'NA', 'light' => 'NA', 'fertility' => 'NA');
                $deviceData[$i] = $deviceData[$i-1];
                $deviceData[$i]->temperature ="NA";
                $deviceData[$i]->humidity ="NA";
                $deviceData[$i]->heatIndex ="NA";
                $deviceData[$i]->voltage ="NA";
                $deviceData[$i]->current ="NA";
                $deviceData[$i]->power ="NA";
                $deviceData[$i]->frequency ="NA";
            }
            $i++;
        }
        // return dd($deviceData);
        return view('home')->with(compact('devices'))->with(compact('deviceData'));
    }



    public function  addDeviceNoData(Request $request)
    {

        $response = Http::post(env('API_ENDPOINT').'device/saveDevice', [
            'temperature' => $request->Temperature,
            'humidity' => $request->Humidity,
            'heatIndex' => $request->HeatIndex,
            'voltage' => $request->Voltage,
            'current' => $request->Current,
            'power' => $request->Power,
            'frequency' => $request->Frequency,
        ]);
        
        if ($response->ok()) {
            // HTTP response status code is in the 2xx range
            echo $response->body();
            
            return redirect()-> back()->with('success',"DeviceNo data added successfully");
        
        } else {
           
            echo 'Error: ' . $response->status();
        }


       
    }



    public function  addDevice()
    {
        return view('addDevice');
    }

    public function addDeviceData(Request $request)
    {
    
        $this->validate($request,[
            'deviceId'=>'required',
            'minTemperature'=>'required|integer',
            'maxTemperature'=>'required|integer',
            'minHumidity'=>'required|integer',
            'maxHumidity'=>'required|integer',
            'minVoltage'=>'required|integer',
            'maxVoltage'=>'required|integer',
        ]);

        if (!Schema::hasTable('device_'.$request->deviceId)) {
            Schema::create('device_'.$request->deviceId, function (Blueprint $table) {
                $table->increments('id');
                $table->string('temperature');
                $table->string('humidity');
                $table->string('heatIndex');
                $table->string('voltage');
                $table->string('current');
                $table->string('power');
                $table->string('frequency');
                $table->timestamps();
            });
        }
        //DB::unprepared('CREATE PROCEDURE InsertIntoDevice_'.$request->deviceId.'(IN `temperature` VARCHAR(255),IN `humidity` VARCHAR(255), IN `heatIndex` VARCHAR(255), IN `voltage` VARCHAR(255), IN `current` VARCHAR(255), IN `power` VARCHAR(255), IN `frequency` VARCHAR(255)) BEGIN INSERT INTO `device_'.$request->deviceId.'` (`created_at`, `temperature`, `humidity`, `heatIndex`, `voltage`, `current`, `power`, `frequency`) VALUES (CURRENT_TIMESTAMP, temperature, humidity, heatIndex, voltage, current, power, frequency); END');

        //DB::insert('insert into device_'.$request->deviceId.' ( temperature,moisture,light,fertility) values (?,?,?,?)', [$request->temperature,$request->moisture,$request->light,$request->fertility]);
        /*
        $devices =new Devices();
        $devices->email=Auth::user()->email;
        $devices->deviceName=$request->deviceId;
        $devices->minTemperature=$request->minTemperature;
        $devices->maxTemperature=$request->maxTemperature;
        $devices->minHumidity=$request->minHumidity;
        $devices->maxHumidity=$request->maxHumidity;
        $devices->minVoltage=$request->minVoltage;
        $devices->maxVoltage=$request->maxVoltage;
        $devices->save();
        */

        $response = Http::post(env('API_ENDPOINT').'device/saveDevice', [
            'email' => Auth::user()->email,
            'device_name' => $request->deviceId,
            'min_temperature' => $request->minTemperature,
            'max_temperature' => $request->maxTemperature,
            'min_humidity' => $request->minHumidity,
            'max_humidity' => $request->maxHumidity,
            'min_voltage' => $request->minVoltage,
            'max_voltage' => $request->maxVoltage,
        ]);
        
        if ($response->ok()) {
            // HTTP response status code is in the 2xx range
            echo $response->body();
            
            return redirect()-> back()->with('success',"Device added successfully");
        
        } else {
           
            echo 'Error: ' . $response->status();
        }

    }

    public function getDevices()
    {
        // pass unseen notification to view
        $devices = Devices::where('email',Auth::user()->email)->get();
        return response($devices);

    }

    public function deviceNo(request $request)
    {
        //dd($request['deviceNo']);

        $environment = DB::table('device_'.$request['deviceNo'])->get();

        /*
            $URI = 'http://127.0.0.1:8080/api/v/device/getDeviceNoData';
        
            $client = new \GuzzleHttp\Client();
            $request = $client->get($URI);
            $response = $request->getBody()->getContents();
            $environment = json_decode($response);

        */

        return view('device')->with(compact('environment'))->with('deviceNo', $request['deviceNo']);
    }

    public function receiveDeviceData(Request $request)
    {


        if($request->dateRange == null) {
            $mytime = Carbon::now()->subDays(1);

            //$data = DB::table('device_'.$request['deviceNo'])->whereRaw('DATE(created_at) > ?', [$mytime])->get();

            $URI = 'http://127.0.0.1:8080/api/v/user/getDevicNoeData/'.[$mytime].'';
        
            $client = new \GuzzleHttp\Client();
            $request = $client->get($URI);
            $response = $request->getBody()->getContents();
            $data = json_decode($response,TRUE);



        }
        else {

            $yearStart = Str::substr($request->dateRange, 6, 4);
            $yearEnd = Str::substr($request->dateRange, 19, 4);

            $monthStart = Str::substr($request->dateRange, 0, 2);
            $monthEnd = Str::substr($request->dateRange, 13, 2);

            $dateStart = (int)Str::substr($request->dateRange, 3, 2);
            $dateEnd = Str::substr($request->dateRange, 16, 2);

            $startDate = new Carbon($yearStart.'-'.$monthStart.'-'.$dateStart.' 00:00:01');
            $endDate = new Carbon($yearEnd.'-'.$monthEnd.'-'.$dateEnd.' 23:59:59');

            //$data = DB::table('device_'.$request['deviceNo'])->whereRaw('DATE(created_at) < ?', [$endDate])->whereRaw('DATE(created_at) > ?', [$startDate])->get();

            $URI = 'http://127.0.0.1:8080/api/v/user/getDeviceData/'.[$endDate].'/'.[$startDate].'/'.$request['deviceNo'].'';
        
            $client = new \GuzzleHttp\Client();
            $request = $client->get($URI);
            $response = $request->getBody()->getContents();
            $data = json_decode($response,TRUE);

           

            return dd($data);
        

        }

        return response($data);
    }

    public function  deviceList()
    {
        //$data = Devices::where('email',Auth::user()->email)->get();;

        

        $URI = 'http://127.0.0.1:8080/api/v/device/getDeviceData/'.Auth ::user()->email.'';
        
        $client = new \GuzzleHttp\Client();
        $request = $client->get($URI);
        $response = $request->getBody()->getContents();
        $data = json_decode($response);

        

    	return view('deviceList', compact('data'));
    }


    public function editDeviceList(Request $request)
    {
        // return dd($request);

        if($request->action == 'edit')
        {

            /*
            $data = array(
                'minTemperature'=>$request->minTemperature,
                'maxTemperature'=>$request->maxTemperature,
                'minHumidity'=>$request->minHumidity,
                'maxHumidity'=>$request->maxHumidity,
                'minVoltage'=>$request->minVoltage,
                'maxVoltage'=>$request->maxVoltage,
            );
            Devices::where('email',Auth::user()->email)->where('device_name', $request->deviceId)->update($data);
            */

            $response = Http::post('http://127.0.0.1:8080/api/v/device/updateDevice', [
                'email' => Auth::user()->email,
                'device_name' => $request->deviceId,
                'min_temperature' => $request->minTemperature,
                'max_temperature' => $request->maxTemperature,
                'min_humidity' => $request->minHumidity,
                'max_humidity' => $request->maxHumidity,
                'min_voltage' => $request->minVoltage,
                'max_voltage' => $request->maxVoltage,
            ]);


        }
        if($request->action == 'delete')
        {
            //Devices::where('email',Auth::user()->email)->where('deviceName', $request->deviceIdDel)->delete();
        
            $response = Http::post('http://127.0.0.1:8080/api/v/device/deleteDevice', [
                'email' => Auth::user()->email,
                'device_name' => $request->deviceIdDel,
            ]);
        
        
        }

        $data = Devices::where('email',Auth::user()->email)->get();;
        /*
        $URI = 'http://127.0.0.1:8080/api/v/device/getDeviceData/'.Auth ::user()->email.'';
        
        $client = new \GuzzleHttp\Client();
        $request = $client->get($URI);
        $response = $request->getBody()->getContents();
        $data = json_decode($response);
        */

    	return view('deviceList', compact('data'));
        return redirect()-> back()->with('success',"Data edited successfully");
    }





}
