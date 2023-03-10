<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\MasterRute;
use App\Models\Wilayah;

class GetDataController extends Controller
{
    public function getSalesman(Request $request)
    {
        $term = $request->input('q');

        $salesman =
            MasterRute::with('w')->select('salesman', 'id_wilayah')
            ->where('salesman', 'LIKE', $term)
            ->groupBy('salesman', 'id_wilayah')
            ->get();

        $results = [];

        foreach ($salesman as $data) {
            $nama_wilayah = $data->w->nama_wilayah ?? '';
            $results[] = [
                'id' => $data->salesman,
                'text' => $data->salesman . " - " . $nama_wilayah
            ];
        }

        return response()->json(['results' => $results]);
    }

    public function getRute(Request $request)
    {
        $term = $request->input('q');
        $salesman = $request->input('salesman');

        $rute = MasterRute::where('rute', 'LIKE', '%' . $term . '%')->where('salesman', '=', $salesman)
            ->pluck('rute', 'id');

        $results = [];

        foreach ($rute as $id => $nama) {
            $results[] = [
                'id' => $id,
                'text' => $nama,
            ];
        }

        return response()->json(['results' => $results]);
    }
}
