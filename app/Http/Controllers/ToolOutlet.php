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

class ToolOutlet extends Controller
{
    public function getSalesman(Request $request)
    {
        $term = $request->input('q');
        $page = $request->input('page', 1);
        $perPage = 10;

        $query =
            MasterRute::select('salesman', 'id_wilayah')
            ->with('w', 'kr')
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
            $id_wilayah = $data->w->id_wilayah ?? '';
            $id_salesman_mss = $data->kr->id_salesman_mss ?? '';
            $results[] = [
                'id' => $data->salesman,
                'text' => $data->salesman,
                'salesman' => $data->salesman,
                'id_salesman' => $id_salesman_mss,
                'nama_wilayah' => $nama_wilayah,
                'id_wilayah' => $id_wilayah
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

        $ruteData = MasterRute::where('rute', 'LIKE', '%' . $term . '%')
            ->where('salesman', $salesman)
            ->orderByDesc('rute')
            ->get(['id', 'rute', 'id_wilayah']);

        $results = [];

        foreach ($ruteData as $rute) {
            $results[] = [
                'id' => $rute->id,
                'text' => $rute->rute
            ];
        }


        return response()->json(['results' => $results]);
    }

    public function getPasar(Request $request)
    {
        $term = $request->input('q');
        $page = $request->input('page', 1);
        // $id_wilayah = $request->input('id_wilayah');
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
        $nama_wilayah_awal = $request->input('nama_wilayah_awal');
        $id_wilayah_awal = $request->input('id_wilayah_awal');
        $rute_id_awal = $request->input('rute_id_awal');
        $rute_awal = $request->input('rute_awal');
        $pasar_awal = $request->input('pasar_awal');
        $id_pasar_awal = $request->input('id_pasar_awal');

        if ($salesman_awal == null && $pasar_awal == null) {
            return view('ToolOutlet', compact('salesman_awal', 'id_salesman_awal', 'nama_wilayah_awal', 'id_wilayah_awal', 'rute_id_awal', 'rute_awal', 'pasar_awal', 'id_pasar_awal'));
        } else {
            $data = MasterRute::select('id', 'rute', 'hari', 'salesman', 'id_wilayah', 'id_distributor')->with([
                'w', 'd' => function ($query) {
                    $query->select('id_distributor', 'nama_distributor');
                }, 'mrdo' => function ($query) use ($id_pasar_awal) {
                    $query->select('id', 'rute_id', 'rute_detail_id', 'survey_pasar_id', 'nama_toko', 'alamat', 'id_pasar', 'tipe_outlet')
                        ->when($id_pasar_awal, function ($q) use ($id_pasar_awal) {
                            $q->where('id_pasar', $id_pasar_awal);
                        });
                    $query->with([
                        'mrd' => function ($subquery) {
                            $subquery->select('id', 'id_pasar', 'nama_pasar');
                        },
                        'mp' => function ($subquery) {
                            $subquery->select('id_pasar', 'nama_pasar');
                        },
                        'mco' => function ($subquery) {
                            $subquery->select('id', 'id_outlet_mas', 'kode_customer');
                        },
                        'sp' => function ($subquery) {
                            $subquery->select('id', 'location_type', 'source_type');
                        },
                    ]);
                },
                'kr' => function ($query) {
                    $query->select('nama', 'id_salesman_mss');
                }
            ])->when($salesman_awal, function ($query, $salesman_awal) {
                return $query->where('salesman', $salesman_awal);
            })->when($rute_id_awal, function ($query, $rute_id_awal) {
                return $query->where('id', $rute_id_awal);
            })->whereHas('mrdo', function ($query) use ($id_pasar_awal) {
                $query->when($id_pasar_awal, function ($q) use ($id_pasar_awal) {
                    $q->where('id_pasar', $id_pasar_awal);
                });
            })->get();

            // return response()->json(['id_salesman' => $id_salesman_awal, 'id_wilayah' => $id_wilayah_awal]);
            return view('ToolOutlet', compact('data', 'salesman_awal', 'id_salesman_awal', 'nama_wilayah_awal', 'id_wilayah_awal', 'rute_id_awal', 'rute_awal', 'pasar_awal', 'id_pasar_awal'));
        }
    }

    public function getOrder(Request $request)
    {
        $id_salesman = $request->input('id_salesman');
        $tgl_transaksi = $request->input('tgl_transaksi');

        $data = Order::select('id', 'nama_wilayah', 'no_order', 'id_salesman', 'nama_salesman', 'nama_toko', 'id_survey_pasar', 'total_rp', 'total_qty', 'total_transaksi', 'tgl_transaksi', 'created_at', 'document', 'platform', 'is_exported', 'kode_customer', 'is_call', 'tipe_order', 'tipe_outlet')->selectRaw('CASE WHEN (order.total_rp = 0) THEN "KUNJUNGAN" ELSE "ORDER" END AS status')
            ->with(['art.ar' => function ($query) {
                $query->select('id', 'kode_customer', 'id_qr_outlet');
            }])->where('id_salesman', $id_salesman)->where('tgl_transaksi', $tgl_transaksi)->get();

        return DataTables::make($data)->addColumn('id_qr_outlet', function ($data) {
            return $data->art->ar->id_qr_outlet ?? "";
        })->toJson();
    }

    public function getKandidat(Request $request)
    {
        $id_salesman = $request->input('id_salesman');
        $tgl_visit = $request->input('tgl_visit');

        $data = VisitKandidat::select('id', 'nama_toko', 'nama_wilayah', 'status', 'reason', 'id_survey_pasar', 'kode_customer', 'tgl_visit', 'lama_visit', 'nama_distributor', 'id_salesman', 'nama_salesman', 'updated_at')->where('id_salesman', $id_salesman)->where('tgl_visit', $tgl_visit)->get();

        return DataTables::make($data)->addColumn('updated_at', function ($row) {
            return date('Y-m-d H:i:s', strtotime($row->updated_at));
        })->toJson();
    }

    public function pindah(Request $request)
    {
        $detail = $request->input('detail');

        return DB::transaction(
            function () use ($detail) {
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
                        ->lockForUpdate()
                        ->first();

                    if ($existingOutlet) {
                        // JIKA DATA OUTLET PADA RUTE TUJUAN SUDAH ADA
                        $mrdo = MasterRuteDetailOutlet::findOrFail($row['id']);
                        // JIKA DATA OUTLET PADA RUTE TUJUAN SAMA DENGAN RUTE ASAL
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

                return response()->json(['message' => 'Outlet Berhasil Dipindah']);
            },
            15
        );
        return response()->json(['message' => 'Terjadi kesalahan saat memproses transaksi.'], 422);
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

            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 422);
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

    public function clear_kode_kandidat(Request $request)
    {
        $salesman = $request->input('salesman');
        DB::beginTransaction();

        try {
            if ($salesman == null) {
                throw new \Exception('Salesman belum dipilih');
            }

            MasterConvertOutlet::join('survey_pasar as sp', 'master_convert_outlet.id_outlet_mas', '=', 'sp.id')
                ->join('master_rute_detail_outlet as mrdo', 'mrdo.survey_pasar_id', '=', 'master_convert_outlet.id_outlet_mas')
                ->join('master_rute as mr', 'mr.id', '=', 'mrdo.rute_id')
                ->where('mr.salesman', $salesman)
                ->update([
                    'master_convert_outlet.kode_customer' => DB::raw('sp.kode_customer'),
                    'master_convert_outlet.nama_outlet_mas' => DB::raw('sp.nama_toko'),
                    'master_convert_outlet.nama_customer' => DB::raw('sp.nama_toko')
                ]);

            DB::commit();
            return response()->json([
                'message' => 'Data berhasil dibersihkan'
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 422);
        }
    }
    public function hapus_ro_double(Request $request)
    {
        $detail = $request->input('detail');
        DB::beginTransaction();

        try {
            if ($detail == null) {
                throw new \Exception('Tidak ada RO Kode Double');
            }
            foreach ($detail as $row) {
                if ($row['id_mrdo'] == null) {
                    throw new \Exception('Data double source type SE - ' . $row['kode_customer']);
                }

                $mrdo = MasterRuteDetailOutlet::findOrFail($row['id_mrdo']);
                $mrdo->delete();
            }

            DB::commit();
            return response()->json([
                'message' => 'Data berhasil dibersihkan'
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 422);
        }
    }
}
