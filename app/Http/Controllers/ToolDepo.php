<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dataar;
use App\Models\MasterConvertOutlet;
use App\Models\MasterRute;
use App\Models\MasterRuteDetailOutlet;
use App\Models\SurveyPasar;
use App\Models\Wilayah;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ToolDepo extends Controller
{
    public function getDepo(Request $request)
    {
        $term = $request->input('q');
        $page = $request->input('page', 1);
        $perPage = 10;

        $query = Wilayah::where('nama_wilayah', 'LIKE', '%' . $term . '%')
            ->orderBy('nama_wilayah')
            ->groupBy('nama_wilayah', 'id_Wilayah');

        $wilayah = $query->paginate($perPage, ['*'], 'page', $page);

        $results = [];

        foreach ($wilayah as $data) {
            $results[] = [
                'id' => $data->id_wilayah,
                'text' => $data->nama_wilayah
            ];
        }

        $response = [
            'results' => $results,
            'pagination' => [
                'more' => $wilayah->hasMorePages(), // Check if there are more pages
            ],
        ];

        return response()->json($response);
    }

    public function updateAr(Request $request)
    {
        $iddepo = $request->input('iddepo');
        try {
            if ($iddepo == null) {
                throw new \Exception('Silahkan pilih Depo');
            }

            $mr = MasterRute::select('id', 'id_wilayah')
                ->with([
                    'mrdo' => function ($query) {
                        $query->select('id', 'rute_id', 'survey_pasar_id')
                            ->whereHas('mco', function ($query) {
                                $query->whereNotNull('kode_customer')
                                    ->where('kode_customer', '!=', '')
                                    ->where('kode_customer', '!=', '0');
                            });
                    },
                    'mrdo.mco' => function ($query) {
                        $query->select('id_outlet_mas', 'kode_customer');
                    }
                ])
                ->where('id_wilayah', $iddepo)
                ->get();


            $req = [];
            $i = 0;
            foreach ($mr as $item) {
                foreach ($item->mrdo as $mrdo) {
                    $req[$i]['kode_customer'] = $mrdo->mco->kode_customer;
                    $req[$i]['iddepo'] = $iddepo;
                    $req[$i]['mrdo_id'] = $mrdo->id;
                    $i++;
                }
            }
            $request = [
                'data' => $req
            ];

            $options = [
                'http' => [
                    'method' => 'POST',
                    'header' => 'Content-Type: application/x-www-form-urlencoded',
                    'content' => http_build_query($request)
                ]
            ];

            $context = stream_context_create($options);
            $response = file_get_contents('https://sales.motasaindonesia.co.id/api/tool/rute/updateArAll', false, $context);
            $data = json_decode($response, true);
            // return view('ListRute', compact('data', 'salesman', 'id_salesman'));
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 422);
        }
    }

    public function updateBySP(Request $request)
    {
        $iddepo = $request->input('iddepo');
        DB::beginTransaction();

        try {
            if ($iddepo == null) {
                throw new \Exception('Silahkan pilih Depo');
            }
            $sp = SurveyPasar::with(['mco', 'mp' => function ($query) {
                $query->select('id_pasar', 'nama_pasar');
            }])->select('id', 'kode_customer', 'nama_toko', 'alamat', 'pemilik', 'id_pasar')->where('id_wilayah', $iddepo)
                // ->where(function ($query) {
                //     $query->whereNull('delete_ro');
                // })
                ->get();

            $mr = MasterRute::with(['d' => function ($query) {
                $query->select('id_distributor', 'nama_distributor');
            }, 'w' => function ($query) {
                $query->select('id_wilayah', 'nama_wilayah');
            }])->where('id_wilayah', $iddepo)->first();

            foreach ($sp as $data_sp) {
                MasterConvertOutlet::where('id_outlet_mas', strval($data_sp->id))->lockForUpdate()->update(['kode_customer' => $data_sp->kode_customer, 'nama_outlet_mas' => $data_sp->nama_toko, 'nama_customer' => $data_sp->nama_toko]);
                // MasterRuteDetailOutlet::where('survey_pasar_id', strval($data_sp->id))->lockForUpdate()->update(['nama_toko' => $data_sp->nama_toko, 'nama_pemilik' => $data_sp->pemilik, 'alamat' => $data_sp->alamat, 'id_pasar' => $data_sp->mp->id_pasar]);
                foreach ($data_sp->mco as $data_mco) {
                    Dataar::where('id_qr_outlet', strval($data_mco->id))->lockForUpdate()->update(['kode_customer' => $data_sp->kode_customer, 'nama_toko' => $data_sp->nama_toko, 'nama_customer' => $data_sp->nama_toko, 'alamat_toko' => $data_sp->alamat, 'nama_pemilik' => $data_sp->pemilik, 'survey_pasar_id' => $data_sp->id, 'id_pasar' => $data_sp->mp->id_pasar ?? null, 'nama_pasar' => $data_sp->mp->nama_pasar ?? null, 'iddepo' => $mr->w->id_wilayah, 'id_wilayah' => $mr->w->id_wilayah, 'nama_depo' => $mr->w->nama_wilayah, 'id_distributor' => $mr->d->id_distributor, 'nama_distributor' => $mr->d->nama_distributor, 'distributor' => $mr->d->id_distributor]);
                }
            }

            DB::commit();
            return response()->json([
                // 'message' => $sp
                'message' => "Berhasil diupdate",
                'data' => $sp,
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 422);
        }
    }
    public function getRute(Request $request)
    {
        $iddepo = $request->input('iddepo');

        setlocale(LC_TIME, 'id_ID');
        // Ambil tanggal hari ini dalam format Carbon
        $today = Carbon::today();
        // Dapatkan nama harinya dalam bahasa Indonesia
        $hariIni = $today->translatedFormat('l');

        DB::beginTransaction();

        try {
            if ($iddepo == null) {
                throw new \Exception('Silahkan pilih Depo');
            }
            $sp = MasterRute::select('id', 'rute', 'hari', 'salesman', 'id_wilayah', 'periodik_jenis')->where('id_wilayah', $iddepo)
                // ->where('hari', $hariIni)
                ->orderBy('salesman')->orderBy('rute')->get();

            DB::commit();
            return response()->json([
                // 'message' => implode(", ", $req)
                'data' => $sp
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 422);
        }
    }

    public function tukarRute(Request $request)
    {
        // setlocale(LC_TIME, 'id_ID');
        // Ambil tanggal hari ini dalam format Carbon
        // $today = Carbon::today();
        // Dapatkan nama harinya dalam bahasa Indonesia
        // $hariIni = $today->translatedFormat('l');

        $detail = $request->input('detail');

        DB::beginTransaction();

        try {
            if ($detail == null) {
                throw new \Exception('Harap pilih rute yang ingin ditukar');
            }
            foreach ($detail as $row) {
                $mr = MasterRute::findOrFail($row['id']);
                if ($row['periodik'] === 'genap') {
                    if ($mr != null) {
                        $mr->rute = $row['hari'] . ' GANJIL';
                        $mr->periodik_jenis = 'ganjil';
                        $mr->save();
                    }
                } else if ($row['periodik'] === 'ganjil') {
                    if ($mr != null) {
                        $mr->rute = $row['hari'] . ' GENAP';
                        $mr->periodik_jenis = 'genap';
                        $mr->save();
                    }
                } else {
                    throw new \Exception('SE Grosir tidak dapat ditukar');
                }
            }

            DB::commit();

            return response()->json(['message' => 'Rute berhasil ditukar']);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 422);
        }
    }
}
