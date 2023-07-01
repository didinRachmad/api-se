<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIController;
use App\Http\Controllers\ExecRekap;
use App\Http\Controllers\GetDataController;
use App\Http\Controllers\RuteId;
use App\Http\Controllers\KodeCustomer;
use App\Http\Controllers\GabungRute;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ListRute;
use App\Http\Controllers\PindahOutlet;
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
})->name('Home.index');

Route::prefix('RuteId')->group(function () {
    Route::get('/', function () {
        return view('RuteId');
    })->name('RuteId.index');
    Route::get('/getSalesman', [RuteId::class, 'getSalesman'])->name('RuteId.getSalesman');
    Route::get('/getRute', [RuteId::class, 'getRute'])->name('RuteId.getRute');
    Route::get('/getPasar', [RuteId::class, 'getPasar'])->name('RuteId.getPasar');
    Route::post('/', [RuteId::class, 'getDataByRuteId'])->middleware('web')->name('RuteId.getDataByRuteId');
    Route::post('/getOrder', [RuteId::class, 'getOrder'])->name('RuteId.getOrder');
    Route::post('/getKandidat', [RuteId::class, 'getKandidat'])->name('RuteId.getKandidat');
    Route::post('/update-alamat', [RuteId::class, 'updateAlamat'])->middleware('web')->name('RuteId.updateAlamat');
    Route::post('/update-kode', [RuteId::class, 'updateKode'])->middleware('web')->name('RuteId.updateKode');
    Route::post('/setOutlet', [RuteId::class, 'setOutlet'])->middleware('web')->name('RuteId.setOutlet');
    Route::post('/pindahPasar', [RuteId::class, 'pindahPasar'])->middleware('web')->name('RuteId.pindahPasar');
});

Route::prefix('KodeCustomer')->group(function () {
    Route::get('/', function () {
        return view('KodeCustomer');
    })->name('KodeCustomer.index');
    Route::post('/autocomplete', [KodeCustomer::class, 'autocomplete'])->middleware('web')->name('KodeCustomer.autocomplete');
    Route::post('/getOrder', [KodeCustomer::class, 'getOrder'])->middleware('web')->name('KodeCustomer.getOrder');
    Route::post('/getDataByKodeCustomer', [KodeCustomer::class, 'getDataByKodeCustomer'])->middleware('web')->name('KodeCustomer.getDataByKodeCustomer');
    Route::post('/update-alamat', [KodeCustomer::class, 'updateAlamat'])->middleware('web')->name('KodeCustomer.updateAlamat');
    Route::post('/update-kode', [KodeCustomer::class, 'updateKode'])->middleware('web')->name('KodeCustomer.updateKode');
    Route::post('/pindah', [KodeCustomer::class, 'pindah'])->middleware('web')->name('KodeCustomer.pindah');
    Route::post('/setOutlet', [KodeCustomer::class, 'setOutlet'])->middleware('web')->name('KodeCustomer.setOutlet');
    Route::post('/updateDataar', [KodeCustomer::class, 'updateDataar'])->middleware('web')->name('KodeCustomer.updateDataar');
});

Route::prefix('GabungRute')->group(function () {
    Route::get('/', function () {
        return view('GabungRute');
    })->name('GabungRute.index');
    Route::get('/getSalesman', [GabungRute::class, 'getSalesman'])->name('GabungRute.getSalesman');
    Route::get('/getRute', [GabungRute::class, 'getRute'])->name('GabungRute.getRute');
    Route::post('/', [GabungRute::class, 'prosesGabungRute'])->middleware('web')->name('GabungRute.prosesGabungRute');
});

Route::prefix('ExecRekap')->group(function () {
    Route::get('/', [ExecRekap::class, 'index'])->name('ExecRekap.index');
});

Route::prefix('PindahOutlet')->group(function () {
    Route::get('/', function () {
        return view('PindahOutlet');
    })->name('PindahOutlet.index');
    Route::get('/getSalesman', [PindahOutlet::class, 'getSalesman'])->name('PindahOutlet.getSalesman');
    Route::get('/getRute', [PindahOutlet::class, 'getRute'])->name('PindahOutlet.getRute');
    Route::get('/getPasar', [PindahOutlet::class, 'getPasar'])->name('PindahOutlet.getPasar');
    Route::post('/', [PindahOutlet::class, 'getDataByRuteId'])->middleware('web')->name('PindahOutlet.getDataByRuteId');
    Route::post('/pindah', [PindahOutlet::class, 'pindah'])->middleware('web')->name('PindahOutlet.pindah');
    Route::post('/pindahPasar', [PindahOutlet::class, 'pindahPasar'])->middleware('web')->name('PindahOutlet.pindahPasar');
});

Route::prefix('ListRute')->group(function () {
    Route::get('/', function () {
        return view('ListRute');
    })->name('ListRute.index');
    Route::get('/getSalesman', [ListRute::class, 'getSalesman'])->name('ListRute.getSalesman');
});

Route::prefix('FaceRecognition')->group(function () {
    Route::get('/', function () {
        return view('FaceRecognition');
    })->name('FaceRecognition.index');
});

// Auth::routes();
// Route::get('/home', [HomeController::class, 'index']);
