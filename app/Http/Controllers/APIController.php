<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\MasterConvertOutlet;
use App\Models\MasterRute;

class APIController extends Controller
{

    public function getDataByKodeCustomer(Request $request)
    {
        $kode_customer = $request->input('kode_customer');

        // $validator = Validator::make($request->all(), [
        //     'kode_customer' => 'required',
        // ]);

        // if ($validator->fails()) {
        //     return redirect()->back()
        //         ->withErrors($validator)
        //         ->withInput($request->all());
        // }

        $data = MasterConvertOutlet::select('id', 'kode_customer', 'id_outlet_mas')->with(['mrdo.mr', 'mrdo.mr.w', 'mrdo.mrd' => function ($query) {
            $query->select('id', 'nama_pasar');
        }])->where('kode_customer', $kode_customer)->get();

        return view('getKodeCustomer', ['data' => $data, 'kode_customer' => $request->input('kode_customer')]);
        // return response()->json($data);
        // return response()->json([
        //     'status' => 'success',
        //     'data' => $data,
        // ]);
    }
    public function getDataByRuteId(Request $request)
    {
        $rute_id = $request->input('rute_id');

        // $validator = Validator::make($request->all(), [
        //     'rute_id' => 'required',
        // ]);

        // if ($validator->fails()) {
        //     return back()
        //         ->withErrors($validator)
        //         ->withInput($request->all());
        // }

        $data =
            MasterRute::with(['w', 'd' => function ($query) {
                $query->select('id_distributor', 'nama_distributor');
            }, 'mrdo.mrd' => function ($query) {
                $query->select('id', 'id_pasar', 'nama_pasar');
            }, 'mrdo.mp' => function ($query) {
                $query->select('id_pasar', 'nama_pasar');
            }, 'mrdo.mco' => function ($query) {
                $query->select('id_outlet_mas', 'kode_customer');
            }])->find($rute_id);

        return view('getRuteId', ['data' => $data, 'rute_id' => $request->input('rute_id')]);
        // return response()->json($data);
        // return response()->json([
        //     'status' => 'success',
        //     'data' => $data,
        // ]);

        // return redirect()->back()->with('success', 'Form berhasil disubmit!');
    }

    public function getData(Request $request)
    {
        $kode_customer = $request->input('kode_customer');

        $data = MasterRute::select([
            'wilayah.id_wilayah',
            'wilayah.nama_wilayah',
            'master_rute.salesman',
            'master_rute.rute',
            'master_rute.hari',
            'distributor.nama_distributor',
            'master_rute_detail_outlet.id',
            'master_rute_detail_outlet.rute_id',
            'master_rute_detail_outlet.rute_detail_id',
            'master_rute_detail_outlet.survey_pasar_id',
            'master_rute_detail_outlet.nama_toko',
            'master_convert_outlet.kode_customer',
            'master_rute_detail_outlet.alamat',
            'master_pasar.nama_pasar',
            'master_rute_detail_outlet.nama_pemilik'
        ])
            ->join('distributor', 'master_rute.id_distributor', '=', 'distributor.id_distributor')
            ->join('wilayah', 'master_rute.id_wilayah', '=', 'wilayah.id_wilayah')
            ->join('master_rute_detail_outlet', 'master_rute.id', '=', 'master_rute_detail_outlet.rute_id')
            ->join('master_rute_detail', 'master_rute_detail.id', '=', 'master_rute_detail_outlet.rute_detail_id')
            ->join('master_pasar', 'master_rute_detail_outlet.id_pasar', '=', 'master_pasar.id_pasar')
            ->join('master_convert_outlet', 'master_rute_detail_outlet.survey_pasar_id', '=', 'master_convert_outlet.id_outlet_mas')
            ->where('master_convert_outlet.kode_customer', '=', $kode_customer)
            ->get();


        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }
}