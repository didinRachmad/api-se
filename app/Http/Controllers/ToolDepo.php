<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dataar;
use App\Models\MasterConvertOutlet;
use App\Models\MasterRute;
use App\Models\MasterRuteDetailOutlet;
use App\Models\Order;
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

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://sales.motasaindonesia.co.id/api/tool/rute/updateArAll');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($request));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_ENCODING, '');
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/x-www-form-urlencoded'
            ]);

            $response = curl_exec($ch);

            $data = json_decode($response, true);
            // return view('ListRute', compact('data', 'salesman', 'id_salesman'));
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 422);
        }
    }

    public function updateArByOrder(Request $request)
    {
        set_time_limit(360);
        $iddepo = $request->input('iddepo');
        try {
            if ($iddepo == null) {
                throw new \Exception('Silahkan pilih Depo');
            }

            $records = DB::connection('mysql2')->table('dataar as ar')
                ->join('artransaction as art', 'art.dataar', '=', 'ar.id')
                ->join('order as o', 'o.document', '=', 'art.document')
                ->select('ar.id as ar_id', 'o.kode_customer as new_kode_customer', 'ar.kode_customer as current_kode_customer')
                ->where('ar.id_wilayah', $iddepo)
                ->whereColumn('o.kode_customer', '!=', 'ar.kode_customer')
                ->get();

            // Melakukan loop untuk memperbarui setiap record
            foreach ($records as $record) {
                DB::connection('mysql2')->table('dataar')
                    ->where('id', $record->ar_id)
                    ->update(['kode_customer' => $record->new_kode_customer]);
            }

            $request = [
                'is_valid' => true,
                'data' => $records
            ];

            return response()->json($request);
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

    public function editNoOrder(Request $request)
    {
        // DB::beginTransaction();
        $request->validate([
            'nama_wilayah' => 'required|string',
            'tanggal' => 'required|date'
        ], [
            'nama_wilayah.required' => 'Nama wilayah harus diisi.',
            'nama_wilayah.string' => 'Nama wilayah harus berupa teks.',
            'tanggal.required' => 'Tanggal harus diisi.',
            'tanggal.date' => 'Tanggal harus dalam format tanggal yang valid.'
        ]);

        try {
            $nama_wilayah = $request->nama_wilayah;
            $tanggal = $request->tanggal;

            switch ($nama_wilayah) {
                case 'WONOGIRI':
                case 'SUKOHARJO':
                case 'SAMARINDA':
                case 'RANTAU PRAPAT':
                case 'JAKARTA TIMUR':
                case 'MEULABOH':
                case 'GARUT':
                case 'BANJARMASIN':
                    $periode = "Bulanan";
                    break;
                default:
                    $periode = "Harian";
            }

            // return response()->json(['message' => $periode], 422);

            $query = Order::select('no_order')
                ->where('nama_wilayah', $nama_wilayah);
            if ($periode == "Harian") {
                $query->where('tgl_transaksi', $tanggal);
            } else {
                $parsedDate = Carbon::parse($tanggal);
                $query->whereYear('tgl_transaksi', $parsedDate->year)
                    ->whereMonth('tgl_transaksi', $parsedDate->month);
            }
            $orders = $query->orderBy('id', 'desc')->get();

            // Group dan hitung masing-masing no_order untuk menemukan duplikasi
            $counted = $orders->groupBy('no_order')->map(function ($group) {
                return count($group);
            });

            // Filter yang duplikat
            $duplicates = $counted->filter(function ($count) {
                return $count > 1;
            });

            if ($duplicates->isEmpty()) {
                return response()->json(['message' => 'No duplicates found'], 422);
            }

            foreach ($duplicates->keys() as $duplicateNoOrder) {
                // Query untuk duplicateOrders
                $duplicateOrdersQuery = Order::select('id', 'no_order', 'nama_salesman', 'kode_customer', 'nama_toko', 'nama_wilayah', 'tgl_transaksi', 'total_transaksi')->where('nama_wilayah', $nama_wilayah)
                    ->where('no_order', $duplicateNoOrder);
                if ($periode == "Harian") {
                    $duplicateOrdersQuery->where('tgl_transaksi', $tanggal);
                } else {
                    $parsedDate = Carbon::parse($tanggal);
                    $duplicateOrdersQuery->whereYear('tgl_transaksi', $parsedDate->year)
                        ->whereMonth('tgl_transaksi', $parsedDate->month);
                }
                $duplicateOrders[] = $duplicateOrdersQuery->orderBy('no_order', 'asc')->get();
            }

            DB::commit();
            return response()->json([
                'data' => $duplicateOrders
            ]);
            // return response()->json(['message' => 'Duplicates have been updated' . $duplicateOrders]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'An error occurred: ' . $e->getMessage()], 422);
        }
    }

    public function saveEditNoOrder(Request $request)
    {
        $id = $request->req;
        $updatedOrders = [];

        DB::beginTransaction();
        try {
            foreach ($id as $Order) {
                switch ($Order['nama_wilayah']) {
                    case 'BANJARNEGARA':
                    case 'PURWOKERTO':
                    case 'BANJARMASIN':
                    case 'SAMARINDA':
                    case 'PADANG SIDEMPUAN':
                        $digitpref = 8;
                        $digit = 4;
                        break;
                    case 'SIDOARJO':
                        $digitpref = 8;
                        $digit = 7;
                        break;
                    case 'RANTAU PRAPAT':
                    case 'WONOGIRI':
                    case 'SUKOHARJO':
                        $digitpref = 7;
                        $digit = 4;
                        break;
                    case 'BANTUL-YK':
                        $digitpref = 9;
                        $digit = 6;
                        break;
                    case 'DENPASAR':
                        $digitpref = 9;
                        $digit = 3;
                        break;
                    case 'MADIUN':
                    case 'MAGETAN':
                    case 'PEMATANG SIANTAR':
                    case 'BALIGE':
                    case 'PONOROGO':
                    case 'SIBOLGA':
                        $digitpref = 9;
                        $digit = 4;
                        break;
                    case 'LUMAJANG':
                    case 'JAKARTA TIMUR':
                    case 'MEULABOH':
                        $digitpref = 10;
                        $digit = 4;
                        break;
                    case 'GUNUNG KIDUL':
                        $digitpref = 12;
                        $digit = 4;
                        break;
                    case 'TEGAL':
                        $digitpref = 8;
                        $digit = 3;
                        break;
                    case 'BANYUWANGI':
                        $digitpref = 2;
                        $digit = 4;
                        break;
                    case 'GARUT':
                        $digitpref = 6;
                        $digit = 6;
                        break;
                    case 'SLEMAN':
                        $digitpref = 13;
                        $digit = 3;
                        break;
                    case 'JEMBER':
                        $digitpref = 7;
                        $digit = 7;
                        break;
                    default:
                        $digitpref = 8; // default value
                        $digit = 4; // default value
                        break;
                }

                $order = Order::where('id', $Order['id'])->lockForUpdate()->firstOrFail();
                $prefix = substr($order->no_order, 0, $digitpref);

                $lastOrder = Order::where('no_order', 'like', $prefix . '%')
                    ->where('nama_wilayah', $Order['nama_wilayah'])
                    ->whereYear('tgl_transaksi', date('Y'))
                    ->whereMonth('tgl_transaksi', date('m'))
                    ->latest('no_order')
                    ->first();

                // Jika tidak ada nomor pesanan sebelumnya, mulai dari nomor 1
                $nextNumber = $lastOrder ? intval(substr($lastOrder->no_order, -$digit)) + 1 : 1;
                $newNoOrder = $prefix . str_pad($nextNumber, $digit, '0', STR_PAD_LEFT);

                // Simpan perubahan nomor pesanan
                $order->no_order = $newNoOrder;
                $order->save();

                $updatedOrders[] = $newNoOrder;
            }
            DB::commit();
            return response()->json(['message' => 'No Order berhasil diupdate | ', 'updated_orders' => $updatedOrders]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'An error occurred while processing order ID ' . $Order['id'] . ': ' . $e->getMessage()], 422);
        }
    }
}
