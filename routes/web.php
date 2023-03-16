<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIController;
use App\Http\Controllers\GetDataController;
use App\Http\Controllers\RuteId;
use App\Http\Controllers\KodeCustomer;
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
        return view('RuteId');
    })->name('RuteId.index');
    Route::get('/getSalesman', [RuteId::class, 'getSalesman'])->name('RuteId.getSalesman');
    Route::get('/getRute', [RuteId::class, 'getRute'])->name('RuteId.getRute');
    Route::post('/', [RuteId::class, 'getDataByRuteId'])
        ->middleware('web')
        ->name('RuteId.getDataByRuteId');
    Route::post('/getOrder', [RuteId::class, 'getOrder'])->name('RuteId.getOrder');
    Route::post('/update-alamat', [RuteId::class, 'updateAlamat'])->middleware('web')
        ->name('RuteId.updateAlamat');
    Route::post('/update-kode', [RuteId::class, 'updateKode'])->middleware('web')
        ->name('RuteId.updateKode');
    Route::post('/setOutlet', [RuteId::class, 'setOutlet'])->middleware('web')
        ->name('RuteId.setOutlet');
});

Route::prefix('KodeCustomer')->group(function () {
    Route::get('/', function () {
        return view('KodeCustomer');
    })->name('KodeCustomer.index');
    Route::post('/', [KodeCustomer::class, 'getDataByKodeCustomer'])
        ->middleware('web')
        ->name('KodeCustomer.getDataByKodeCustomer');
    Route::post('/update-alamat', [KodeCustomer::class, 'updateAlamat'])->middleware('web')
        ->name('KodeCustomer.updateAlamat');
    Route::post('/update-kode', [KodeCustomer::class, 'updateKode'])->middleware('web')
        ->name('KodeCustomer.updateKode');
    Route::post('/setOutlet', [KodeCustomer::class, 'setOutlet'])->middleware('web')
        ->name('KodeCustomer.setOutlet');
});

// Auth::routes();
Route::get('/home', [HomeController::class, 'index']);
