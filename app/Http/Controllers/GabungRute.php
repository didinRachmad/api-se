<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MasterRute;
use App\Models\MasterRutePengganti;
use Illuminate\Http\Request;

class GabungRute extends Controller
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

    public function prosesGabungRute(Request $request)
    {
        $salesman = $request->input('salesman');
        $id_salesman = $request->input('id_salesman');
        $rute_id = $request->input('rute_id');
        $rute = $request->input('rute');
        $tgl_pengganti = $request->input('tgl_pengganti');

        $masterRutePengganti = new MasterRutePengganti();
        $masterRutePengganti->rute_id = $rute_id;
        $masterRutePengganti->tgl_pengganti = $tgl_pengganti;
        $masterRutePengganti->remarks = $salesman;
        $masterRutePengganti->save();

        return view('GabungRute', compact('salesman', 'id_salesman', 'rute_id', 'rute'));
        // return response()->json($data);
        // return redirect()->back()->with('success', 'Form berhasil disubmit!');
    }
}
