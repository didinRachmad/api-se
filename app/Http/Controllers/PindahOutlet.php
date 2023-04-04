<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dataar;
use App\Models\MasterConvertOutlet;
use App\Models\MasterPasar;
use App\Models\MasterRute;
use App\Models\MasterRuteDetail;
use App\Models\MasterRuteDetailOutlet;
use App\Models\Order;
use App\Models\VisitKandidat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

class PindahOutlet extends Controller
{
    public function getSalesman(Request $request)
    {
        $term = $request->input('q');

        $salesman =
            MasterRute::select('salesman', 'id_wilayah')->with('w', 'kr')
            ->where('salesman', 'LIKE', '%' . $term . '%')
            ->groupBy('salesman', 'id_wilayah')
            ->get();

        $results = [];

        foreach ($salesman as $data) {
            $nama_wilayah = $data->w->nama_wilayah ?? '';
            $id_salesman_mss = $data->kr->id_salesman_mss ?? '';
            $results[] = [
                'id' => $data->salesman,
                'text' => $data->salesman,
                'salesman' => $data->salesman,
                'nama_wilayah' => $nama_wilayah,
                'id_salesman' => $id_salesman_mss
            ];
        }

        return response()->json(['results' => $results]);
    }

    public function getRute(Request $request)
    {
        $term = $request->input('q');
        $salesman = $request->input('salesman');

        $rute = MasterRute::where('rute', 'LIKE', '%' . $term . '%')->where('salesman', $salesman)
            ->pluck('rute', 'id');

        $results = [];

        foreach ($rute as $id => $rute) {
            $results[] = [
                'id' => $id,
                'text' => $rute,
            ];
        }

        return response()->json(['results' => $results]);
    }

    public function getDataByRuteId(Request $request)
    {
        $salesman_awal = $request->input('salesman_awal');
        $id_salesman_awal = $request->input('id_salesman_awal');
        $rute_id_awal = $request->input('rute_id_awal');
        $rute_awal = $request->input('rute_awal');

        $data =
            MasterRute::with(['w', 'd' => function ($query) {
                $query->select('id_distributor', 'nama_distributor');
            }, 'mrdo.mrd' => function ($query) {
                $query->select('id', 'id_pasar', 'nama_pasar');
            }, 'mrdo.mp' => function ($query) {
                $query->select('id_pasar', 'nama_pasar');
            }, 'mrdo.mco' => function ($query) {
                $query->select('id', 'id_outlet_mas', 'kode_customer');
            }])->where('salesman', $salesman_awal)->when($rute_id_awal, function ($query, $rute_id_awal) {
                return $query->where('id', $rute_id_awal);
            })->get();

        return view('PindahOutlet', compact('data', 'salesman_awal', 'id_salesman_awal', 'rute_id_awal', 'rute_awal'));
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
                if (!$row['rute_id_akhir']) {
                    throw new \Exception('Rute Tujuan tidak boleh kosong');
                }
                // Mencari data MRD berdasarkan id_pasar dan rute_id
                $mrd = MasterRuteDetail::where('id_pasar', $row['id_pasar_awal'])
                    ->where('rute_id', $row['rute_id_akhir'])
                    ->first();

                if ($mrd) {

                    // Jika data MRD ditemukan, maka update rute_id
                    $mrdo = MasterRuteDetailOutlet::findOrFail($row['id']);
                    $mrdo->rute_id = $row['rute_id_akhir'];
                    $mrdo->rute_detail_id = $mrd->id;
                    $mrdo->save();
                } else {
                    // Jika tidak ditemukan, tambahkan data baru ke MRD
                    $mp = MasterPasar::where('id_pasar', $row['id_pasar_awal'])->first();

                    $mrd = new MasterRuteDetail();
                    $mrd->rute_id = $row['rute_id_akhir'];
                    $mrd->KODE_WILAYAH_kecamatan = $mp->KODE_WILAYAH_kecamatan;
                    $mrd->kecamatan = $mp->kecamatan;
                    $mrd->id_pasar = $row['id_pasar_awal'];
                    $mrd->nama_pasar = $mp->nama_pasar;
                    $mrd->rute_asal = 'senew';
                    $mrd->save();

                    $mrdo = MasterRuteDetailOutlet::findOrFail($row['id']);
                    $mrdo->rute_id = $row['rute_id_akhir'];
                    $mrdo->rute_detail_id = $mrd->id;
                    $mrdo->save();
                }
            }

            DB::commit();

            return response()->json(['message' => 'Outlet Berhasil Dipindah']);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }
}
