<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

       $URI = 'http://127.0.0.1:8080/api/v/user/getUserByEmail/'.$credentials['email'].'';
        
        $client = new \GuzzleHttp\Client();
        $request = $client->get($URI);
        $response = $request->getBody()->getContents();
        $json = json_decode($response);
        
        //Auth::attempt($credentials)
        
        
        if ($json->email != null) {

        
            if (Hash::check($credentials['password'], $json->password)) {
                Auth::attempt($credentials);
                return redirect()->route('home');
            }else{

                return redirect()->back()->withErrors([
                    'password' => 'Wrong password',
                ]);
            }
            
            
            //return \Redirect::route('route-name-here');
        }
        
        // Authentication failed
        
        return redirect()->back()->withErrors([
            'email' => 'Wrong Email',
        ]);
        
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
