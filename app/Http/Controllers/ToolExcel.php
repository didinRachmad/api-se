<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MasterConvertOutlet;
use App\Models\MasterPasar;
use App\Models\MasterRute;
use App\Models\MasterRuteDetail;
use App\Models\MasterRuteDetailOutlet;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ToolExcel extends Controller
{
    public function index()
    {
        return view('ToolExcel');
    }

    public function getDataOutlet(Request $request)
    {
        ini_set('max_input_vars', 15000);
        $wilayah = strtoupper($request->input('wilayah'));
        $kode_customer = $request->input('kode_customer');

        $data = MasterConvertOutlet::with('mrdo.mr')
            ->select('id', 'kode_customer', 'id_outlet_mas')
            ->whereIn(DB::raw('UPPER(kode_customer)'), array_map('strtoupper', $kode_customer))
            ->whereHas('mrdo.mr.w', function ($query) use ($wilayah) {
                $query->where('nama_wilayah', $wilayah);
            })->orderBy('id', 'desc')
            ->get();

        return response()->json(['data' => $data]);

        // return view('KodeCustomer', compact('data', 'kode_customer'));
    }
    public function pindah(Request $request)
    {
        $detail = $request->input('detail');

        DB::beginTransaction();

        try {
            if ($detail == null) {
                throw new \Exception('Harap pilih Rute tujuan');
            }
            foreach ($detail as $row) {
                $rute_id_akhir = MasterRute::select('id')->where('salesman', $row['salesman_tujuan'])
                    ->where('rute', $row['hari_tujuan'])
                    ->first();

                if (!$rute_id_akhir->id) {
                    throw new \Exception('Rute Tujuan tidak boleh kosong');
                }

                $tgl_sekarang = Carbon::now()->format('Y-m-d');

                // CEK APAKAH DATA KUNJUNGAN PADA OUTLET YANG AKAN DIPINDAH SUDAH ADA DI HARI INI
                $existingOrder = Order::where('id_survey_pasar', $row['id_survey_pasar'])->where('tgl_transaksi', $tgl_sekarang)->first();
                if ($existingOrder) {
                    throw new \Exception('Sudah terdapat kunjungan pada rute yang dipindah = ' . $existingOrder->nama_salesman . '   |   ' . $existingOrder->nama_toko . '   |   ' . $existingOrder->tgl_transaksi . '   |   ' . $existingOrder->total_transaksi);
                }

                // CEK APAKAH DATA OUTLET PADA RUTE TUJUAN SUDAH ADA
                $existingOutlet = MasterRuteDetailOutlet::where('rute_id', $rute_id_akhir->id)
                    ->where('survey_pasar_id', $row['id_survey_pasar'])
                    ->first();

                if ($existingOutlet) {
                    // JIKA DATA OUTLET PADA RUTE TUJUAN SUDAH ADA
                    $mrdo = MasterRuteDetailOutlet::findOrFail($row['id']);
                    // JIKA DATA OUTLET PADA RUTE TUJUAN TIDAK SAMA DENGAN RUTE ASAL
                    if ($mrdo->rute_id != $rute_id_akhir->id) {
                        $mrdo->delete();
                    }
                } else {

                    // Mencari data MRD berdasarkan id_pasar dan rute_id
                    $mrd = MasterRuteDetail::where('id_pasar', $row['id_pasar_awal'])
                        ->where('rute_id', $rute_id_akhir->id)
                        ->first();

                    if ($mrd) {

                        // Jika data MRD ditemukan, maka update rute_id
                        $mrdo = MasterRuteDetailOutlet::findOrFail($row['id']);
                        $mrdo->rute_id = $rute_id_akhir->id;
                        $mrdo->rute_detail_id = $mrd->id;
                        $mrdo->save();
                    } else {
                        // Jika tidak ditemukan, tambahkan data baru ke MRD
                        $mp = MasterPasar::where('id_pasar', $row['id_pasar_awal'])->first();

                        $mrd = new MasterRuteDetail();
                        $mrd->rute_id = $rute_id_akhir->id;
                        $mrd->KODE_WILAYAH_kecamatan = $mp->KODE_WILAYAH_kecamatan;
                        $mrd->kecamatan = $mp->kecamatan;
                        $mrd->id_pasar = $row['id_pasar_awal'];
                        $mrd->nama_pasar = $mp->nama_pasar;
                        $mrd->rute_asal = 'senew';
                        $mrd->save();

                        $mrdo = MasterRuteDetailOutlet::findOrFail($row['id']);
                        $mrdo->rute_id = $rute_id_akhir->id;
                        $mrdo->rute_detail_id = $mrd->id;
                        $mrdo->save();
                    }
                }
            }

            DB::commit();

            return response()->json(['message' => 'Outlet Berhasil Dipindah']);
            // return response()->json(['message' => $rute_id_akhir->id]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 422);
        }
    }
}
