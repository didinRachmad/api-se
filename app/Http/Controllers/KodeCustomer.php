<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dataar;
use App\Models\MasterConvertOutlet;
use App\Models\MasterRuteDetailOutlet;
use Illuminate\Http\Request;

class KodeCustomer extends Controller
{
    public function getDataByKodeCustomer(Request $request)
    {
        $kode_customer = $request->input('kode_customer');

        $data = MasterConvertOutlet::with(['mrdo.mr.w', 'mrdo.mrd' => function ($query) {
            $query->select('id', 'id_pasar', 'nama_pasar');
        }])->select('id', 'kode_customer', 'id_outlet_mas')->where('kode_customer', $kode_customer)->get();

        // return response()->json(['data' => $data]);

        return view('KodeCustomer', compact('data', 'kode_customer'));
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
