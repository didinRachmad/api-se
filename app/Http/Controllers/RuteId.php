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
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RuteId extends Controller
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
        $salesman = $request->input('salesman');
        $id_salesman = $request->input('id_salesman');
        $rute_id = $request->input('rute_id');
        $rute = $request->input('rute');

        $data =
            MasterRute::with(['w', 'd' => function ($query) {
                $query->select('id_distributor', 'nama_distributor');
            }, 'mrdo.mrd' => function ($query) {
                $query->select('id', 'id_pasar', 'nama_pasar');
            }, 'mrdo.mp' => function ($query) {
                $query->select('id_pasar', 'nama_pasar');
            }, 'mrdo.mco' => function ($query) {
                $query->select('id', 'id_outlet_mas', 'kode_customer');
            }, 'kr' => function ($query) {
                $query->select('nama', 'id_salesman_mss');
            }])->where('salesman', $salesman)->when($rute_id, function ($query, $rute_id) {
                return $query->where('id', $rute_id);
            })->get();

        return view('RuteId', compact('data', 'salesman', 'id_salesman', 'rute_id', 'rute'));
        // return response()->json($data);
        // return redirect()->back()->with('success', 'Form berhasil disubmit!');
    }

    public function getOrder(Request $request)
    {
        $id_salesman = $request->input('id_salesman');
        $tgl_transaksi = $request->input('tgl_transaksi');

        $data = Order::select('id', 'nama_wilayah', 'no_order', 'id_salesman', 'nama_salesman', 'nama_toko', 'id_survey_pasar', 'total_rp', 'total_qty', 'total_transaksi', 'tgl_transaksi', 'document', 'closed_order', 'platform')->selectRaw('CASE WHEN (order.total_rp = 0) THEN "KUNJUNGAN" ELSE "ORDER" END AS status')
            ->with(['art' => function ($query) {
                $query->select('dataar', 'document');
                $query->with(['ar' => function ($query) {
                    $query->select('id', 'kode_customer', 'id_qr_outlet');
                }]);
            }])->where('id_salesman', $id_salesman)->where('tgl_transaksi', $tgl_transaksi)->get();

        return DataTables::make($data)->addColumn('id_qr_outlet', function ($data) {
            return $data->art->ar->id_qr_outlet;
        })->addColumn('kode_customer', function ($data) {
            return $data->art->ar->kode_customer;
        })->toJson();
    }

    public function getKandidat(Request $request)
    {
        $id_salesman = $request->input('id_salesman');
        $tgl_visit = $request->input('tgl_visit');

        $data = VisitKandidat::select('nama_toko', 'nama_wilayah', 'status', 'reason', 'kode_customer', 'tgl_visit', 'lama_visit', 'nama_distributor', 'id_salesman', 'nama_salesman', 'updated_at')->where('id_salesman', $id_salesman)->where('tgl_visit', $tgl_visit)->get();

        return DataTables::make($data)->addColumn('updated_at', function ($row) {
            return date('Y-m-d H:i:s', strtotime($row->updated_at));
        })->toJson();
    }

    public function getPasar(Request $request)
    {
        $term = $request->input('q');
        $page = $request->input('page', 1);
        $perPage = 10;

        $query = MasterPasar::select('master_pasar.id_pasar as id_pasar', 'master_pasar.nama_pasar as nama_pasar', 'wilayah.nama_wilayah as nama_wilayah')
            ->join('wilayah', 'master_pasar.id_wilayah', '=', 'wilayah.id_wilayah')
            ->where('master_pasar.nama_pasar', 'LIKE', '%' . $term . '%')
            ->orWhere('master_pasar.id_pasar', 'LIKE', '%' . $term . '%')
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


    public function updateAlamat(Request $request)
    {
        try {
            DB::beginTransaction();

            $mrdo = MasterRuteDetailOutlet::where('survey_pasar_id', $request->survey_pasar_id)->update(['alamat' => $request->alamat, 'nama_toko' => $request->nama_toko]);
            if ($mrdo == null) {
                throw new \Exception('No Master Rute Detail Outlet Updated');
            }

            $mco = MasterConvertOutlet::where('id_outlet_mas', $request->survey_pasar_id)->update(['nama_outlet_mas' => $request->nama_toko, 'nama_outlet_verda' => $request->nama_toko, 'nama_customer' => $request->nama_toko]);
            if ($mco == null && $mrdo == null) {
                throw new \Exception('No Master Convert Outlet Updated' . $mco);
            }

            $sp = SurveyPasar::find($request->survey_pasar_id);
            if ($sp != null) {
                $sp->alamat = $request->alamat;
                $sp->nama_toko = $request->nama_toko;
                $sp->save();
            } else {
                throw new \Exception('Survey Pasar kosong');
            }

            $ar = Dataar::where('id_qr_outlet', $request->id_mco)->orWhere('survey_pasar_id', $request->survey_pasar_id)->update(['alamat_toko' => $request->alamat, 'nama_toko' => $request->nama_toko, 'nama_customer' => $request->nama_toko]);
            if ($ar == null) {
                throw new \Exception('Dataar kosong');
            }

            DB::commit();

            return response()->json([
                'alamat' => $request->alamat,
                'nama_toko' => $request->nama_toko
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function updateKode(Request $request)
    {
        try {
            DB::beginTransaction();

            $mco = MasterConvertOutlet::find($request->id_mco);
            if ($mco != null) {
                $mco->kode_customer = strtoupper($request->kodeBaru);
                $mco->save();
            } else {
                throw new \Exception('MCO kosong');
            }

            $sp = SurveyPasar::find($request->survey_pasar_id);
            if ($sp != null) {
                $sp->kode_customer = strtoupper($request->kodeBaru);
                $sp->save();
            } else {
                throw new \Exception('Survey Pasar kosong');
            }

            $ar = Dataar::where('survey_pasar_id', $request->survey_pasar_id)->update(['kode_customer' => strtoupper($request->kodeBaru)]);
            if ($ar == null) {
                throw new \Exception('Dataar kosong');
            }

            // Order::where('id_survey_pasar', $request->survey_pasar_id)->update(['kode_customer' => strtoupper($request->kodeBaru)]);

            DB::commit();

            return response()->json([
                'kode_customer' => $mco->kode_customer
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function setOutlet(Request $request)
    {
        $mrdo = MasterRuteDetailOutlet::find($request->id_mrdo);
        if ($mrdo != null) {
            $mrdo->tipe_outlet = $request->set;
            $mrdo->save();
        }

        Dataar::where('id_qr_outlet', $request->id_mco)->update(['tipe_outlet' => $request->set]);

        return response()->json([
            'tipe_outlet' => $mrdo->tipe_outlet
        ]);
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
}
