<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
//use App\Http\Controllers\LController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/addDevice', [HomeController::class,'addDevice'])->name('addDevice');
Route::post('/addDeviceData', [HomeController::class,'addDeviceData'])->name('addDeviceData');
Route::get('/deviceList',  [HomeController::class,'deviceList'])->name('deviceList');
Route::post('/editDeviceList',  [HomeController::class,'editDeviceList'])->name('editDeviceList');

Route::get('/getDevices', [HomeController::class, 'getDevices'])->name('getDevices');
Route::post('/deviceNo', [HomeController::class, 'deviceNo'])->name('deviceNo');

Route::get('/receiveDeviceData', [HomeController::class, 'receiveDeviceData'])->name('receiveDeviceData');
Route::get('/searchDeviceData', [HomeController::class, 'searchDeviceData'])->name('searchDeviceData');


