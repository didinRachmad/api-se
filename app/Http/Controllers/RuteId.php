<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MasterRute;
use App\Models\MasterRuteDetailOutlet;
use Illuminate\Http\Request;

class RuteId extends Controller
{
    public function getDataByRuteId(Request $request)
    {
        $salesman = $request->input('salesman');
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
                $query->select('id_outlet_mas', 'kode_customer');
            }])->where('salesman', '=', $salesman)->when($rute_id, function ($query, $rute_id) {
                return $query->where('id', '=', $rute_id);
            })->get();

        return view('getRuteId', ['data' => $data, 'salesman' => $salesman, 'rute_id' => $rute_id, 'rute' => $rute]);
        // return response()->json($data);
        // return redirect()->back()->with('success', 'Form berhasil disubmit!');
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
}
