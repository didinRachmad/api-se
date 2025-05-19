<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dataar;
use App\Models\MasterRute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ListRute extends Controller
{
    public function getSalesman(Request $request)
    {
        $term = $request->input('q');
        $page = $request->input('page', 1);
        $perPage = 10;

        $query = MasterRute::select('salesman', 'id_wilayah')->with('w', 'kr')
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
            $id_salesman_mss = $data->kr->id_salesman_mss ?? '';
            $results[] = [
                'id' => $data->salesman,
                'text' => $data->salesman,
                'salesman' => $data->salesman,
                'nama_wilayah' => $nama_wilayah,
                'id_salesman' => $id_salesman_mss
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

    public function getListRute(Request $request)
    {
        $salesman = $request->input('salesman');
        $id_salesman = $request->input('id_salesman');

        // Validasi sederhana
        if (!$id_salesman) {
            return back()->with('error', 'NIK tidak boleh kosong');
        }

        // Kirim request ke API
        $response = Http::post('https://sales.motasaindonesia.co.id/api/downloadrute/getListRute', [
            'id_salesman' => $id_salesman
        ]);

        if ($response->successful()) {
            $dataApi = $response->json();

            $data = $dataApi['data'] ?? [];
            $message = $dataApi['message'] ?? '';
            $id_salesman = $dataApi['id_salesman'] ?? $id_salesman;
            $total = $dataApi['total'] ?? 0;
            $ro = $dataApi['total_ro'] ?? 0;
            $kandidat = intval($total) - intval($ro);
            return view('ListRute', compact('data', 'message', 'salesman', 'id_salesman', 'total', 'ro', 'kandidat'));
        } else {
            return back()->with('error', 'Gagal mengambil data dari API');
        }
    }
}
