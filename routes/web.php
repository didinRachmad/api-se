<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIController;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
});
Route::get('/getKodeCustomer', function () {
    return view('getKodeCustomer');
});
Route::get('/getRuteId', function () {
    return view('getRuteId');
});

Route::post('/getKodeCustomer', [APIController::class, 'getDataByKodeCustomer'])->middleware('web')->name('getKodeCustomer');
Route::post('/getRuteId', [APIController::class, 'getDataByRuteId'])->middleware('web')->name('getRuteId');
Route::post('/getData', [APIController::class, 'getData'])->middleware('web')->name('getData');

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);
