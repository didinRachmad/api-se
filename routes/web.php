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
use App\Http\Controllers\ToolExcel;
use App\Http\Controllers\ToolOutlet;
use App\Http\Controllers\ToolDepo;
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

// Route::prefix('RuteId')->group(function () {
//     Route::get('/', function () {
//         return view('RuteId');
//     })->name('RuteId.index');
//     Route::get('/getSalesman', [RuteId::class, 'getSalesman'])->name('RuteId.getSalesman');
//     Route::get('/getRute', [RuteId::class, 'getRute'])->name('RuteId.getRute');
//     Route::get('/getPasar', [RuteId::class, 'getPasar'])->name('RuteId.getPasar');
//     Route::post('/', [RuteId::class, 'getDataByRuteId'])->middleware('web')->name('RuteId.getDataByRuteId');
//     Route::post('/getOrder', [RuteId::class, 'getOrder'])->name('RuteId.getOrder');
//     Route::post('/getKandidat', [RuteId::class, 'getKandidat'])->name('RuteId.getKandidat');
//     Route::post('/update-alamat', [RuteId::class, 'updateAlamat'])->middleware('web')->name('RuteId.updateAlamat');
//     Route::post('/update-kode', [RuteId::class, 'updateKode'])->middleware('web')->name('RuteId.updateKode');
//     Route::post('/setOutlet', [RuteId::class, 'setOutlet'])->middleware('web')->name('RuteId.setOutlet');
//     Route::post('/pindahPasar', [RuteId::class, 'pindahPasar'])->middleware('web')->name('RuteId.pindahPasar');
// });

Route::prefix('KodeCustomer')->group(function () {
    Route::get('/', function () {
        return view('KodeCustomer');
    })->name('KodeCustomer.index');
    Route::post('/', [KodeCustomer::class, 'getDataByKodeCustomer'])->middleware('web')->name('KodeCustomer.getDataByKodeCustomer');
    Route::post('/autocomplete', [KodeCustomer::class, 'autocomplete'])->middleware('web')->name('KodeCustomer.autocomplete');
    Route::get('/getPasar', [KodeCustomer::class, 'getPasar'])->name('KodeCustomer.getPasar');
    Route::post('/getOrder', [KodeCustomer::class, 'getOrder'])->middleware('web')->name('KodeCustomer.getOrder');
    Route::get('/getSalesman', [KodeCustomer::class, 'getSalesman'])->middleware('web')->name('KodeCustomer.getSalesman');
    Route::get('/getRute', [KodeCustomer::class, 'getRute'])->middleware('web')->name('KodeCustomer.getRute');
    Route::post('/update-alamat', [KodeCustomer::class, 'editOutlet'])->middleware('web')->name('KodeCustomer.editOutlet');
    Route::post('/update-kode', [KodeCustomer::class, 'updateKode'])->middleware('web')->name('KodeCustomer.updateKode');
    Route::post('/pindah', [KodeCustomer::class, 'pindah'])->middleware('web')->name('KodeCustomer.pindah');
    Route::post('/setOutlet', [KodeCustomer::class, 'setOutlet'])->middleware('web')->name('KodeCustomer.setOutlet');
    Route::post('/updateDataar', [KodeCustomer::class, 'updateDataar'])->middleware('web')->name('KodeCustomer.updateDataar');
});

// Route::prefix('GabungRute')->group(function () {
//     Route::get('/', function () {
//         return view('GabungRute');
//     })->name('GabungRute.index');
//     Route::get('/getSalesman', [GabungRute::class, 'getSalesman'])->name('GabungRute.getSalesman');
//     Route::get('/getRute', [GabungRute::class, 'getRute'])->name('GabungRute.getRute');
//     Route::post('/', [GabungRute::class, 'prosesGabungRute'])->middleware('web')->name('GabungRute.prosesGabungRute');
// });

Route::prefix('ToolOutlet')->group(function () {
    Route::get('/', function () {
        return view('ToolOutlet');
    })->name('ToolOutlet.index');
    Route::post('/', [ToolOutlet::class, 'getDataByRuteId'])->middleware('web')->name('ToolOutlet.getDataByRuteId');
    Route::get('/getSalesman', [ToolOutlet::class, 'getSalesman'])->name('ToolOutlet.getSalesman');
    Route::get('/getRute', [ToolOutlet::class, 'getRute'])->name('ToolOutlet.getRute');
    Route::get('/getPasar', [ToolOutlet::class, 'getPasar'])->name('ToolOutlet.getPasar');
    Route::post('/getOrder', [ToolOutlet::class, 'getOrder'])->name('ToolOutlet.getOrder');
    Route::post('/getKandidat', [ToolOutlet::class, 'getKandidat'])->name('ToolOutlet.getKandidat');
    Route::post('/pindah', [ToolOutlet::class, 'pindah'])->middleware('web')->name('ToolOutlet.pindah');
    Route::post('/pindahPasar', [ToolOutlet::class, 'pindahPasar'])->middleware('web')->name('ToolOutlet.pindahPasar');
    Route::post('/pindahLokasi', [ToolOutlet::class, 'pindahLokasi'])->middleware('web')->name('ToolOutlet.pindahLokasi');
    Route::post('/setOutlet', [ToolOutlet::class, 'setOutlet'])->middleware('web')->name('ToolOutlet.setOutlet');
    Route::post('/clear_kode_kandidat', [ToolOutlet::class, 'clear_kode_kandidat'])->name('ToolOutlet.clear_kode_kandidat');
    Route::post('/hapus_ro_double', [ToolOutlet::class, 'hapus_ro_double'])->name('ToolOutlet.hapus_ro_double');
});

Route::prefix('ListRute')->group(function () {
    Route::get('/', function () {
        return view('ListRute');
    })->name('ListRute.index');
    Route::get('/getSalesman', [ListRute::class, 'getSalesman'])->name('ListRute.getSalesman');
    Route::post('/getListRute', [ListRute::class, 'getListRute'])->name('ListRute.getListRute');
});

Route::prefix('ExecRekap')->group(function () {
    Route::get('/', [ExecRekap::class, 'index'])->name('ExecRekap.index');
});

Route::prefix('ToolDepo')->group(function () {
    Route::get('/', function () {
        return view('ToolDepo');
    })->name('ToolDepo.index');
    Route::get('/getDepo', [ToolDepo::class, 'getDepo'])->name('ToolDepo.getDepo');
    Route::post('/updateAr', [ToolDepo::class, 'updateAr'])->middleware('web')->name('ToolDepo.updateAr');
    Route::post('/updateBySP', [ToolDepo::class, 'updateBySP'])->middleware('web')->name('ToolDepo.updateBySP');
    Route::post('/getRute', [ToolDepo::class, 'getRute'])->middleware('web')->name('ToolDepo.getRute');
    Route::post('/tukarRute', [ToolDepo::class, 'tukarRute'])->middleware('web')->name('ToolDepo.tukarRute');
});

Route::prefix('ToolExcel')->group(function () {
    Route::get('/', [ToolExcel::class, 'index'])->name('ToolExcel.index');
    Route::post('/getDataOutlet', [ToolExcel::class, 'getDataOutlet'])->middleware('web')->name('ToolExcel.getDataOutlet');
    Route::post('/pindah', [ToolExcel::class, 'pindah'])->middleware('web')->name('ToolExcel.pindah');
});

// Route::prefix('FaceRecognition')->group(function () {
//     Route::get('/', function () {
//         return view('FaceRecognition');
//     })->name('FaceRecognition.index');
// });

// Auth::routes();
// Route::get('/home', [HomeController::class, 'index']);
