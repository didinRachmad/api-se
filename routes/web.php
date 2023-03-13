<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIController;
use App\Http\Controllers\GetDataController;
use App\Http\Controllers\RuteId;
use App\Http\Controllers\HomeController;
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


Route::prefix('RuteId')->group(function () {
    Route::get('/', function () {
        return view('getRuteId');
    })->name('getRuteId.index');

    Route::post('/', [RuteId::class, 'getDataByRuteId'])
        ->middleware('web')
        ->name('getRuteId.getDataByRuteId');

    Route::post('/update-alamat', [RuteId::class, 'updateAlamat'])
        ->name('getRuteId.updateAlamat');
});

Route::get('/getSalesman', [GetDataController::class, 'getSalesman'])->name('getSalesman');
Route::get('/getRute', [GetDataController::class, 'getRute'])->name('getRute');

Route::get('/getKodeCustomer', function () {
    return view('getKodeCustomer');
});


Route::post('/getKodeCustomer', [APIController::class, 'getDataByKodeCustomer'])->middleware('web')->name('getKodeCustomer');
Route::post('/getData', [APIController::class, 'getData'])->middleware('web')->name('getData');

// Auth::routes();
Route::get('/home', [HomeController::class, 'index']);
