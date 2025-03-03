<?php

use App\Http\Controllers\ListRKM;
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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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

// Route::prefix('RuteId')->middleware(['web', 'checkReferer'])->group(function () {
//     Route::get('/', function () {
//         return view('RuteId');
//     })->name('RuteId.index');
//     Route::get('/getSalesman', [RuteId::class, 'getSalesman'])->name('RuteId.getSalesman');
//     Route::get('/getRute', [RuteId::class, 'getRute'])->name('RuteId.getRute');
//     Route::get('/getPasar', [RuteId::class, 'getPasar'])->name('RuteId.getPasar');
//     Route::post('/', [RuteId::class, 'getDataByRuteId'])->name('RuteId.getDataByRuteId');
//     Route::post('/getOrder', [RuteId::class, 'getOrder'])->name('RuteId.getOrder');
//     Route::post('/getKandidat', [RuteId::class, 'getKandidat'])->name('RuteId.getKandidat');
//     Route::post('/update-alamat', [RuteId::class, 'updateAlamat'])->name('RuteId.updateAlamat');
//     Route::post('/update-kode', [RuteId::class, 'updateKode'])->name('RuteId.updateKode');
//     Route::post('/setOutlet', [RuteId::class, 'setOutlet'])->name('RuteId.setOutlet');
//     Route::post('/pindahPasar', [RuteId::class, 'pindahPasar'])->name('RuteId.pindahPasar');
// });

Route::prefix('KodeCustomer')->middleware(['web', 'checkReferer'])->group(function () {
    Route::get('/', function () {
        return view('KodeCustomer');
    })->name('KodeCustomer.index');
    Route::post('/', [KodeCustomer::class, 'getDataByKodeCustomer'])->name('KodeCustomer.getDataByKodeCustomer');
    Route::post('/autocomplete', [KodeCustomer::class, 'autocomplete'])->name('KodeCustomer.autocomplete');
    Route::get('/getPasar', [KodeCustomer::class, 'getPasar'])->name('KodeCustomer.getPasar');
    Route::post('/getOrder', [KodeCustomer::class, 'getOrder'])->name('KodeCustomer.getOrder');
    Route::get('/getSalesman', [KodeCustomer::class, 'getSalesman'])->name('KodeCustomer.getSalesman');
    Route::get('/getRute', [KodeCustomer::class, 'getRute'])->name('KodeCustomer.getRute');
    Route::get('/getToken', [KodeCustomer::class, 'getToken'])->name('KodeCustomer.getToken');
    Route::post('/update-alamat', [KodeCustomer::class, 'editOutlet'])->name('KodeCustomer.editOutlet');
    Route::post('/update-kode', [KodeCustomer::class, 'updateKode'])->name('KodeCustomer.updateKode');
    Route::post('/pindah', [KodeCustomer::class, 'pindah'])->name('KodeCustomer.pindah');
    Route::post('/setOutlet', [KodeCustomer::class, 'setOutlet'])->name('KodeCustomer.setOutlet');
    Route::post('/cekOrder', [KodeCustomer::class, 'cekOrder'])->name('KodeCustomer.cekOrder');
    Route::post('/updateDataar', [KodeCustomer::class, 'updateDataar'])->name('KodeCustomer.updateDataar');
});

// Route::prefix('GabungRute')->middleware(['web', 'checkReferer'])->group(function () {
//     Route::get('/', function () {
//         return view('GabungRute');
//     })->name('GabungRute.index');
//     Route::get('/getSalesman', [GabungRute::class, 'getSalesman'])->name('GabungRute.getSalesman');
//     Route::get('/getRute', [GabungRute::class, 'getRute'])->name('GabungRute.getRute');
//     Route::post('/', [GabungRute::class, 'prosesGabungRute'])->name('GabungRute.prosesGabungRute');
// });

Route::prefix('ToolOutlet')->middleware(['web', 'checkReferer'])->group(function () {
    Route::get('/', function () {
        return view('ToolOutlet');
    })->name('ToolOutlet.index');
    Route::post('/', [ToolOutlet::class, 'getDataByRuteId'])->name('ToolOutlet.getDataByRuteId');
    Route::get('/getSalesman', [ToolOutlet::class, 'getSalesman'])->name('ToolOutlet.getSalesman');
    Route::get('/getHari', [ToolOutlet::class, 'getHari'])->name('ToolOutlet.getHari');
    Route::get('/getRute', [ToolOutlet::class, 'getRute'])->name('ToolOutlet.getRute');
    Route::get('/getPasar', [ToolOutlet::class, 'getPasar'])->name('ToolOutlet.getPasar');
    Route::get('/getWilayah', [ToolOutlet::class, 'getWilayah'])->name('ToolOutlet.getWilayah');
    Route::post('/getOrder', [ToolOutlet::class, 'getOrder'])->name('ToolOutlet.getOrder');
    Route::post('/getKandidat', [ToolOutlet::class, 'getKandidat'])->name('ToolOutlet.getKandidat');
    Route::post('/pindah', [ToolOutlet::class, 'pindah'])->name('ToolOutlet.pindah');
    Route::post('/pindahPasar', [ToolOutlet::class, 'pindahPasar'])->name('ToolOutlet.pindahPasar');
    Route::post('/pindahLokasi', [ToolOutlet::class, 'pindahLokasi'])->name('ToolOutlet.pindahLokasi');
    Route::post('/setOutlet', [ToolOutlet::class, 'setOutlet'])->name('ToolOutlet.setOutlet');
    Route::post('/clear_kode_kandidat', [ToolOutlet::class, 'clear_kode_kandidat'])->name('ToolOutlet.clear_kode_kandidat');
    Route::post('/hapus_ro_double', [ToolOutlet::class, 'hapus_ro_double'])->name('ToolOutlet.hapus_ro_double');
    Route::get('/get/select2salesman', function (Request $request) {
        $response = Http::get('https://sales.motasaindonesia.co.id/order/select2salesman', [
            'search' => $request->query('search'),
        ]);

        return $response->json();
    })->name('ToolOutlet.getSalesmanAPI');
});

Route::prefix('ListRute')->middleware(['web', 'checkReferer'])->group(function () {
    Route::get('/', function () {
        return view('ListRute');
    })->name('ListRute.index');
    Route::get('/getSalesman', [ListRute::class, 'getSalesman'])->name('ListRute.getSalesman');
    Route::post('/getListRute', [ListRute::class, 'getListRute'])->name('ListRute.getListRute');
});

Route::prefix('ListRKM')->middleware(['web', 'checkReferer'])->group(function () {
    Route::get('/', function () {
        return view('ListRKM');
    })->name('ListRKM.index');
    Route::get('/getKaryawan', [ListRKM::class, 'getKaryawan'])->name('ListRKM.getKaryawan');
    Route::post('/getListRKM', [ListRKM::class, 'getListRKM'])->name('ListRKM.getListRKM');
});

Route::prefix('ExecRekap')->middleware(['web', 'checkReferer'])->group(function () {
    Route::get('/', [ExecRekap::class, 'index'])->name('ExecRekap.index');
});

Route::prefix('ToolDepo')->middleware(['web', 'checkReferer'])->group(function () {
    Route::get('/', function () {
        return view('ToolDepo');
    })->name('ToolDepo.index');
    Route::get('/getDepo', [ToolDepo::class, 'getDepo'])->name('ToolDepo.getDepo');
    Route::post('/updateAr', [ToolDepo::class, 'updateAr'])->name('ToolDepo.updateAr');
    Route::post('/updateArByOrder', [ToolDepo::class, 'updateArByOrder'])->name('ToolDepo.updateArByOrder');
    Route::post('/updateBySP', [ToolDepo::class, 'updateBySP'])->name('ToolDepo.updateBySP');
    Route::post('/getRute', [ToolDepo::class, 'getRute'])->name('ToolDepo.getRute');
    Route::post('/tukarRute', [ToolDepo::class, 'tukarRute'])->name('ToolDepo.tukarRute');
    Route::post('/editNoOrder', [ToolDepo::class, 'editNoOrder'])->name('ToolDepo.editNoOrder');
    Route::post('/saveEditNoOrder', [ToolDepo::class, 'saveEditNoOrder'])->name('ToolDepo.saveEditNoOrder');
});

Route::prefix('ToolExcel')->middleware(['web', 'checkReferer'])->group(function () {
    Route::get('/', [ToolExcel::class, 'index'])->name('ToolExcel.index');
    Route::post('/getDataOutlet', [ToolExcel::class, 'getDataOutlet'])->name('ToolExcel.getDataOutlet');
    Route::post('/pindah', [ToolExcel::class, 'pindah'])->name('ToolExcel.pindah');
});

// Route::prefix('FaceRecognition')->middleware(['web', 'checkReferer'])->group(function () {
//     Route::get('/', function () {
//         return view('FaceRecognition');
//     })->name('FaceRecognition.index');
// });

// Auth::routes();
// Route::get('/home', [HomeController::class, 'index']);
