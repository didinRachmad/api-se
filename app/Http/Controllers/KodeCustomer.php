<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dataar;
use App\Models\MasterConvertOutlet;
use App\Models\MasterPasar;
use App\Models\MasterRute;
use App\Models\MasterRuteDetail;
use App\Models\MasterRuteDetailOutlet;
use App\Models\MembershipOutletToken;
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

        $req = array(
            'kode_customer' => array($kode_customer),
            'type' => "ro",
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://sales.motasaindonesia.co.id/api/tool/outletkandidat/getData');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($req));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded'
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            $error_message = curl_error($ch);
            $message = "Kesalahan cURL: $error_message";
            curl_close($ch);
            echo $message;
        } else {
            curl_close($ch);

            $res = json_decode($response, true);
            $data = $res['data'] ?? [];
            // return response()->json($data);
            if (json_last_error() !== JSON_ERROR_NONE) {
                echo "Kesalahan dekode JSON: " . json_last_error_msg();
            } elseif ($res === null) {
                echo "Respons JSON tidak valid.";
            } else {
                return view('KodeCustomer', compact('data', 'kode_customer'));
            }
        }
    }

    public function autocomplete(Request $request)
    {
        $term = $request->input('term');

        $data = MasterConvertOutlet::select('kode_customer')
            ->where('kode_customer', 'LIKE', '%' . $term . '%')
            ->groupBy('kode_customer')
            ->orderBy('kode_customer')
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

        $threeMonthsAgo = Carbon::now()->subMonths(4)->startOfMonth()->toDateString();

        $data = Order::select('id', 'nama_wilayah', 'no_order', 'id_salesman', 'nama_salesman', 'nama_toko', 'id_survey_pasar', 'total_rp', 'total_qty', 'total_transaksi', 'tgl_transaksi', 'document', 'platform', 'is_exported', 'kode_customer', 'is_call', 'tipe_order', 'tipe_outlet')
            ->selectRaw('CASE WHEN (total_rp = 0) THEN "KUNJUNGAN" ELSE "ORDER" END AS status')
            ->whereDate('tgl_transaksi', '>=', $threeMonthsAgo)
            ->where(function ($query) use ($kode_customer) {
                $query->where('kode_customer', $kode_customer)
                    ->orWhereHas('art.ar', function ($query) use ($kode_customer) {
                        $query->select('id', 'kode_customer', 'id_qr_outlet')->where('kode_customer', $kode_customer);
                    });
            })
            ->orderBy('tgl_transaksi')
            ->orderBy('id_salesman')
            ->get();

        // return response()->json(['data' => $data]);
        return DataTables::make($data)->addColumn('id_qr_outlet', function ($data) {
            return $data->art->ar->id_qr_outlet ?? "";
        })->toJson();
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

        $ruteData = MasterRute::where('rute', 'LIKE', '%' . $term . '%')
            ->where('salesman', $salesman)
            ->orderByDesc('rute')
            ->get(['id', 'rute', 'id_wilayah']);

        $results = [];

        foreach ($ruteData as $rute) {
            $results[] = [
                'id' => $rute->id,
                'text' => $rute->rute,
                'id_wilayah' => $rute->id_wilayah
            ];
        }

        return response()->json(['results' => $results]);
    }

    public function getPasar(Request $request)
    {
        $term = $request->input('q');
        $page = $request->input('page', 1);
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

    public function editOutlet(Request $request)
    {
        try {
            DB::beginTransaction();

            $mrdo = MasterRuteDetailOutlet::where('survey_pasar_id', $request->survey_pasar_id)->lockForUpdate()->update(['alamat' => $request->alamat, 'nama_toko' => $request->nama_toko]);
            if ($mrdo === null) {
                throw new \Exception('No Master Rute Detail Outlet Updated');
            }

            $mco = MasterConvertOutlet::where('id', $request->id_mco)->lockForUpdate()->firstOrFail();
            if ($mco === null) {
                throw new \Exception('MCO kosong');
            }

            // $sp = SurveyPasar::where('id', $request->survey_pasar_id)->lockForUpdate()->firstOrFail();
            // if ($sp === null) {
            //     throw new \Exception('Survey Pasar kosong');
            // }

            $ar = Dataar::where('id_qr_outlet', $request->id_mco)->orWhere('survey_pasar_id', $request->survey_pasar_id)->lockForUpdate()->update(['alamat_toko' => $request->alamat, 'nama_toko' => $request->nama_toko, 'nama_customer' => $request->nama_toko, 'kode_customer' => $request->kode_customer]);
            if ($ar === null) {
                throw new \Exception('Dataar kosong');
            }

            // $o = Order::where('id_survey_pasar', $request->survey_pasar_id)->where('id_salesman', $request->id_salesman)->lockForUpdate()->update(['kode_customer' => $request->kode_customer, 'nama_toko' => $request->nama_toko]);
            // if ($o === null) {
            //     throw new \Exception('No Order Updated');
            // }

            // UPDATE MCO
            $mco->kode_customer = strtoupper($request->kode_customer);
            $mco->nama_outlet_mas = $request->nama_toko;
            $mco->nama_customer = $request->nama_toko;
            $mco->save();

            // UPDATE SP
            // $sp->alamat = $request->alamat;
            // $sp->nama_toko = $request->nama_toko;
            // $sp->kode_customer = $request->kode_customer;
            // $sp->save();

            DB::commit();

            return response()->json([
                'alamat' => $request->alamat,
                'nama_toko' => $request->nama_toko,
                'kode_customer' => $request->kode_customer
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 422);
        }
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
                ->lockForUpdate()
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
                    ->lockForUpdate()
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

            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 422);
        }
    }

    public function setOutlet(Request $request)
    {
        DB::beginTransaction();

        try {
            $mrdo = MasterRuteDetailOutlet::where('id', $request->id_mrdo)->lockForUpdate()->firstOrFail();
            if ($mrdo) {
                $mrdo->tipe_outlet = $request->set;
                $mrdo->save();
            }

            Dataar::where('id_qr_outlet', $request->id_mco)->lockForUpdate()->update(['tipe_outlet' => $request->set]);

            DB::commit();
            return response()->json([
                'tipe_outlet' => $mrdo->tipe_outlet
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 422);
        }
    }

    public function cekOrder(Request $request)
    {
        $id_survey_pasar = $request->input('id_survey_pasar');
        $tgl_sekarang = Carbon::now()->format('Y-m-d');

        // Cek apakah ada orderan di hari ini
        $cekOrder = Order::where('id_survey_pasar', $id_survey_pasar)
            ->whereDate('tgl_transaksi', $tgl_sekarang)
            ->exists();

        return response()->json([
            'is_valid' => $cekOrder,
            'message' => $cekOrder ? null : "Data kunjungan belum masuk ke sistem, jika sudah dikunjungi, silakan upload ulang dahulu datanya"
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

            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 422);
        }
    }

    public function getToken(Request $request)
    {
        $kode_customer = $request->input('kode_customer');

        $token = MembershipOutletToken::select('membership_outlet_token.token', 'membership_outlet_token.no_hp')
            ->join('dataar', 'dataar.survey_pasar_id', '=', 'membership_outlet_token.id_survey_pasar')
            ->where('dataar.kode_customer', $kode_customer)
            ->whereNotNull('membership_outlet_token.no_hp')
            ->distinct()
            ->first();

        // $results = [];

        // foreach ($token as $rute) {
        //     $results[] = [
        //         'id' => $rute->id,
        //         'text' => $rute->rute,
        //         'id_wilayah' => $rute->id_wilayah
        //     ];
        // }

        return response()->json(['results' => $token]);
    }
}
