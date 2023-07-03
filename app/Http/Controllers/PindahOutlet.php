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
use App\Models\SurveyPasar;
use App\Models\VisitKandidat;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

class PindahOutlet extends Controller
{
    public function getSalesman(Request $request)
    {
        $term = $request->input('q');
        $page = $request->input('page', 1);
        $perPage = 10;

        $query =
            MasterRute::select('salesman', 'id_wilayah')->with('w', 'kr')
            ->where('salesman', 'LIKE', '%' . $term . '%')
            ->orWhereHas('w', function ($query) use ($term) {
                $query->where('nama_wilayah', 'LIKE', '%' . $term . '%');
            })
            ->orderBy('id_wilayah')
            ->groupBy('salesman', 'id_wilayah');

        $salesman = $query->paginate($perPage, ['*'], 'page', $page);

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

        $response = [
            'results' => $results,
            'pagination' => [
                'more' => $salesman->hasMorePages(), // Check if there are more pages
            ],
        ];

        return response()->json($response);
    }

    public function getRute(Request $request)
    {
        $term = $request->input('q');
        $salesman = $request->input('salesman');

        $rute = MasterRute::where('rute', 'LIKE', '%' . $term . '%')->where('salesman', $salesman)->orderByDesc('rute')
            ->pluck('rute', 'id');

        $results = [];

        foreach ($rute as $id => $text) {
            $results[] = [
                'id' => $id,
                'text' => $text,
            ];
        }

        return response()->json(['results' => $results]);
    }

    public function getPasar(Request $request)
    {
        $term = $request->input('q');
        $page = $request->input('page', 1);
        $id_wilayah = $request->input('id_wilayah');
        $perPage = 10;

        $query = MasterPasar::select('master_pasar.id_pasar as id_pasar', 'master_pasar.nama_pasar as nama_pasar', 'wilayah.nama_wilayah as nama_wilayah')
            ->join('wilayah', 'master_pasar.id_wilayah', '=', 'wilayah.id_wilayah')
            // ->where('master_pasar.id_wilayah', '=', $id_wilayah)
            ->Where(function ($query) use ($term) {
                $query->where('master_pasar.nama_pasar', 'LIKE', '%' . $term . '%')
                    ->orWhere('master_pasar.id_pasar', 'LIKE', '%' . $term . '%');
            })
            ->orderBy('master_pasar.id_pasar')
            ->groupBy('master_pasar.id_pasar', 'master_pasar.nama_pasar', 'wilayah.nama_wilayah');

        $mp = $query->paginate($perPage, ['*'], 'page', $page);

        $results = [];

        foreach ($mp as $pasar) {
            $results[] = [
                'id' => $pasar->id_pasar,
                'text' => $pasar->nama_pasar,
                'id_pasar' => $pasar->id_pasar,
                'nama_wilayah' => $pasar->nama_wilayah,
            ];
        }

        $response = [
            'results' => $results,
            'pagination' => [
                'more' => $mp->hasMorePages(), // Check if there are more pages
            ],
        ];

        return response()->json($response);
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
            }, 'kr'])->where('salesman', $salesman_awal)->when($rute_id_awal, function ($query, $rute_id_awal) {
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

                $tgl_sekarang = Carbon::now()->format('Y-m-d');

                // CEK APAKAH DATA KUNJUNGAN PADA OUTLET YANG AKAN DIPINDAH SUDAH ADA DI HARI INI
                $existingOrder = Order::where('id_survey_pasar', $row['id_survey_pasar'])->where('tgl_transaksi', $tgl_sekarang)->first();
                if ($existingOrder) {
                    throw new \Exception('Sudah terdapat kunjungan pada rute yang dipindah = ' . $existingOrder->nama_salesman . '   |   ' . $existingOrder->nama_toko . '   |   ' . $existingOrder->tgl_transaksi . '   |   ' . $existingOrder->total_transaksi);
                }

                // CEK APAKAH DATA OUTLET PADA RUTE TUJUAN SUDAH ADA
                $existingOutlet = MasterRuteDetailOutlet::where('rute_id', $row['rute_id_akhir'])
                    ->where('survey_pasar_id', $row['id_survey_pasar'])
                    ->first();

                if ($existingOutlet) {
                    // JIKA DATA OUTLET PADA RUTE TUJUAN SUDAH ADA
                    $mrdo = MasterRuteDetailOutlet::findOrFail($row['id']);
                    // JIKA DATA OUTLET PADA RUTE TUJUAN TIDAK SAMA DENGAN RUTE ASAL
                    if ($mrdo->rute_id != $row['rute_id_akhir']) {
                        $mrdo->delete();
                    }
                } else {

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
            }

            DB::commit();

            return response()->json(['message' => 'Outlet Berhasil Dipindah']);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function pindahPasar(Request $request)
    {
        set_time_limit(240);
        $detail = $request->input('detail');

        DB::beginTransaction();

        try {
            if ($detail == null) {
                throw new \Exception('Harap pilih Rute tujuan');
            }
            foreach ($detail as $row) {
                if (!$row['id_pasar_akhir']) {
                    throw new \Exception('Pasar Tujuan tidak boleh kosong');
                }

                $sp = SurveyPasar::findOrFail($row['id_survey_pasar']);
                if ($sp->source_type == 'MAS') {
                    throw new \Exception('Outlet MAS | ' . $sp->id . ' | ' . $sp->nama_toko);
                }

                $mp = MasterPasar::where('id_pasar', $row['id_pasar_akhir'])->first();

                // Mencari data MRD berdasarkan id_pasar dan rute_id
                $mrd = MasterRuteDetail::where('id_pasar', $row['id_pasar_akhir'])
                    ->where('rute_id', $row['rute_id_awal'])
                    ->first();

                if ($mrd) {

                    // Jika data MRD ditemukan, maka update rute_id
                    MasterRuteDetailOutlet::where('survey_pasar_id', $row['id_survey_pasar'])->update([
                        'rute_detail_id' => $mrd->id,
                        'id_pasar' => $row['id_pasar_akhir']
                    ]);

                    // $mrdo = MasterRuteDetailOutlet::findOrFail($row['id']);
                    // $mrdo->rute_detail_id = $mrd->id;
                    // $mrdo->id_pasar = $row['id_pasar_akhir'];
                    // $mrdo->save();
                } else {
                    // Jika tidak ditemukan, tambahkan data baru ke MRD
                    $mrd = new MasterRuteDetail();
                    $mrd->rute_id = $row['rute_id_awal'];
                    $mrd->KODE_WILAYAH_kecamatan = $mp->KODE_WILAYAH_kecamatan;
                    $mrd->kecamatan = $mp->kecamatan;
                    $mrd->id_pasar = $mp->id_pasar;
                    $mrd->nama_pasar = $mp->nama_pasar;
                    $mrd->rute_asal = 'senew';
                    $mrd->save();

                    MasterRuteDetailOutlet::where('survey_pasar_id', $row['id_survey_pasar'])->update([
                        'rute_detail_id' => $mrd->id,
                        'id_pasar' => $row['id_pasar_akhir']
                    ]);
                    // $mrdo = MasterRuteDetailOutlet::findOrFail($row['id']);
                    // $mrdo->rute_detail_id = $mrd->id;
                    // $mrdo->id_pasar = $mp->id_pasar;
                    // $mrdo->save();
                }

                $sp = SurveyPasar::findOrFail($row['id_survey_pasar']);
                if ($sp != null) {
                    $sp->id_pasar = $row['id_pasar_akhir'];
                    $sp->save();
                } else {
                    throw new \Exception('Survey Pasar kosong');
                }

                $ar = Dataar::where('id_qr_outlet', $row['id_mco'])->orWhere('survey_pasar_id', $row['id_survey_pasar'])->update([
                    'id_pasar' => $mp->id_pasar,
                    'nama_pasar' => $mp->nama_pasar
                ]);
                if ($ar == null) {
                    throw new \Exception('Dataar kosong : ' . $row['id_mco'] . " - " . $row['id_survey_pasar']);
                }
            }

            DB::commit();

            return response()->json(['message' => 'Outlet Berhasil Dipindah']);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }
    public function pindahLokasi(Request $request)
    {
        set_time_limit(240);
        $detail = $request->input('detail');

        DB::beginTransaction();

        try {
            if ($detail == null) {
                throw new \Exception('Harap pilih lokasi tujuan');
            }
            foreach ($detail as $row) {
                $sp = SurveyPasar::findOrFail($row['id_survey_pasar']);
                if ($sp != null) {
                    $sp->location_type = $row['lokasi'];
                    $sp->save();
                } else {
                    throw new \Exception('Survey Pasar kosong');
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
