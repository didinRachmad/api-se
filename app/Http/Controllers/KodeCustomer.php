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
use Carbon\Carbon;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KodeCustomer extends Controller
{
    public function getDataByKodeCustomer(Request $request)
    {
        $kode_customer = strtoupper($request->input('kode_customer'));

        $data = MasterConvertOutlet::with(['mrdo.mr.w', 'mrdo.mr.kr', 'mrdo.mrd' => function ($query) {
            $query->select('id', 'id_pasar', 'nama_pasar');
        }, 'sp' => function ($query) {
            $query->select('id');
        }])->select('id', 'kode_customer', 'id_outlet_mas')->where('kode_customer', $kode_customer)->get();

        // return response()->json(['data' => $data]);

        return view('KodeCustomer', compact('data', 'kode_customer'));
    }

    public function autocomplete(Request $request)
    {
        $term = $request->input('term');

        $data = MasterConvertOutlet::select('kode_customer')
            ->where('kode_customer', 'LIKE', '%' . $term . '%')
            ->groupBy('kode_customer')
            ->get();

        $results = [];

        foreach ($data as $item) {
            $results[] = [
                'value' => $item->kode_customer,
            ];
        }

        return response()->json($results);
    }

    public function getOrder(Request $request)
    {
        $kode_customer = strtoupper($request->input('kode_customer'));

        $threeMonthsAgo = Carbon::now()->subMonths(3)->startOfMonth()->toDateString();
        // dd($threeMonthsAgo);

        $data = Order::select('id', 'nama_wilayah', 'no_order', 'id_salesman', 'nama_salesman', 'nama_toko', 'id_survey_pasar', 'total_rp', 'total_qty', 'total_transaksi', 'tgl_transaksi', 'document', 'closed_order', 'platform')
            ->selectRaw('CASE WHEN (total_rp = 0) THEN "KUNJUNGAN" ELSE "ORDER" END AS status')
            ->with(['art.ar' => function ($query) use ($kode_customer) {
                $query->select('id', 'kode_customer', 'id_qr_outlet')
                    ->where('kode_customer', $kode_customer);
            }])
            ->where('kode_customer', $kode_customer)
            ->orWhereHas('art.ar', function ($query) use ($kode_customer) {
                $query->where('kode_customer', $kode_customer);
            })
            ->whereDate('tgl_transaksi', '>=', $threeMonthsAgo)
            ->orderBy('tgl_transaksi')
            ->orderBy('id_salesman')
            ->get();

        // return response()->json(['data' => $data]);
        return DataTables::make($data)->addColumn('id_qr_outlet', function ($data) {
            return $data->art->ar->id_qr_outlet ?? "";
        })->addColumn('kode_customer', function ($data) {
            return $data->art->ar->kode_customer ?? "";
        })->toJson();
    }


    public function updateAlamat(Request $request)
    {
        try {
            DB::beginTransaction();

            $mrdo = MasterRuteDetailOutlet::where('survey_pasar_id', $request->survey_pasar_id)->update(['alamat' => $request->alamat, 'nama_toko' => $request->nama_toko]);
            if ($mrdo == null) {
                throw new \Exception('No Master Rute Detail Outlet Updated');
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

            $ar = Dataar::where('id_qr_outlet', $request->id_mco)->orWhere('survey_pasar_id', $request->survey_pasar_id)->update(['kode_customer' => strtoupper($request->kodeBaru)]);
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

    public function getSalesman(Request $request)
    {
        $term = $request->input('q');
        $page = $request->input('page', 1);
        $perPage = 10;

        $query = MasterRute::select('salesman', 'id_wilayah')
            ->with('w', 'kr')
            ->where('salesman', 'LIKE', '%' . $term . '%')
            ->orWhereHas('w', function ($query) use ($term) {
                $query->where('nama_wilayah', 'LIKE', '%' . $term . '%');
            })
            ->groupBy('salesman', 'id_wilayah');

        // Ambil data salesman dengan paginasi
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

        // Mengatur response dengan hasil data dan informasi paginasi
        $response = [
            'results' => $results,
            'pagination' => [
                'more' => $salesman->hasMorePages(), // Menentukan apakah masih ada data yang tersedia
            ],
        ];

        return response()->json($response);
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

    public function pindah(Request $request)
    {
        $id = $request->input('id');
        $id_pasar_awal = $request->input('id_pasar_awal');
        $rute_id_akhir = $request->input('rute_id_akhir');
        $id_survey_pasar = $request->input('id_survey_pasar');

        DB::beginTransaction();

        try {
            if ($rute_id_akhir == null) {
                throw new \Exception('Harap pilih Rute tujuan');
            }

            // CEK APAKAH DATA OUTLET PADA RUTE TUJUAN SUDAH ADA
            $existingOutlet = MasterRuteDetailOutlet::where('rute_id', $rute_id_akhir)
                ->where('survey_pasar_id', $id_survey_pasar)
                ->first();

            if ($existingOutlet) {
                // JIKA DATA OUTLET PADA RUTE TUJUAN SUDAH ADA
                $mrdo = MasterRuteDetailOutlet::findOrFail($id);
                // JIKA DATA OUTLET PADA RUTE TUJUAN SAMA DENGAN RUTE ASAL
                if ($mrdo->rute_id != $rute_id_akhir) {
                    $mrdo->delete();
                }
            } else {

                // Mencari data MRD berdasarkan id_pasar dan rute_id
                $mrd = MasterRuteDetail::where('id_pasar', $id_pasar_awal)
                    ->where('rute_id', $rute_id_akhir)
                    ->first();

                if ($mrd) {

                    // Jika data MRD ditemukan, maka update rute_id
                    $mrdo = MasterRuteDetailOutlet::findOrFail($id);
                    $mrdo->rute_id = $rute_id_akhir;
                    $mrdo->rute_detail_id = $mrd->id;
                    $mrdo->save();
                } else {
                    // Jika tidak ditemukan, tambahkan data baru ke MRD
                    $mp = MasterPasar::where('id_pasar', $id_pasar_awal)->first();

                    $mrd = new MasterRuteDetail();
                    $mrd->rute_id = $rute_id_akhir;
                    $mrd->KODE_WILAYAH_kecamatan = $mp->KODE_WILAYAH_kecamatan;
                    $mrd->kecamatan = $mp->kecamatan;
                    $mrd->id_pasar = $id_pasar_awal;
                    $mrd->nama_pasar = $mp->nama_pasar;
                    $mrd->rute_asal = 'senew';
                    $mrd->save();

                    $mrdo = MasterRuteDetailOutlet::findOrFail($id);
                    $mrdo->rute_id = $rute_id_akhir;
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

    public function updateDataar(Request $request)
    {
        set_time_limit(120);
        DB::beginTransaction();

        // $dataar = Dataar::where('iddepo', '3')->get();
        $dataar = Dataar::where('survey_pasar_id', $request->id_survey_pasar)->get();
        $jumlah = 0;
        try {
            foreach ($dataar as $row) {
                $mco = MasterConvertOutlet::where('id', $row['id_qr_outlet'])->orWhere('id_outlet_mas', $row['survey_pasar_id'])
                    ->first();

                if ($mco) {
                    $mrdo = MasterRuteDetailOutlet::where('survey_pasar_id', $mco->id_outlet_mas)
                        ->first();

                    if ($mrdo) {
                        $row->id_pasar = $mrdo->id_pasar;

                        $mp = MasterPasar::where('id_pasar', $mrdo->id_pasar)->first();

                        $row->nama_pasar = $mp->nama_pasar;
                        $row->save();

                        $jumlah++;
                    } else {
                        // throw new \Exception('MRDO kosong : ' . $mco->id_outlet_mas);
                    }
                } else {
                    // throw new \Exception('MCO kosong');
                }
            }

            DB::commit();

            return response()->json(['message' => 'Outlet Berhasil Diupdate : ' . $jumlah]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }
}
