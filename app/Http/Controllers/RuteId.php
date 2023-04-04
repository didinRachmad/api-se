<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dataar;
use App\Models\MasterConvertOutlet;
use App\Models\MasterRute;
use App\Models\MasterRuteDetailOutlet;
use App\Models\Order;
use App\Models\VisitKandidat;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

class RuteId extends Controller
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


    public function updateAlamat(Request $request)
    {
        $mrdo = MasterRuteDetailOutlet::find($request->id);
        $mrdo->alamat = $request->alamat;
        $mrdo->save();

        return response()->json([
            'alamat' => $mrdo->alamat
        ]);
    }

    public function updateKode(Request $request)
    {
        $mco = MasterConvertOutlet::find($request->id_mco);
        if ($mco != null) {
            $mco->kode_customer = $request->kodeBaru;
            $mco->save();
        }

        Dataar::where('id_qr_outlet', $request->id_mco)->update(['kode_customer' => $request->kodeBaru]);

        return response()->json([
            'kode_customer' => $mco->kode_customer
        ]);
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
}
