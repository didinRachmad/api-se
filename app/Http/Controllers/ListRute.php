<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MasterRute;
use Illuminate\Http\Request;

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

        $request = [
            'id_salesman' => $id_salesman
        ];

        $options = [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-Type: application/x-www-form-urlencoded',
                'content' => http_build_query($request)
            ]
        ];

        $context = stream_context_create($options);
        $response = file_get_contents('http://10.11.1.37/api/downloadrute/getListRute', false, $context);
        $data = json_decode($response, true);

        if ($response !== false && isset($data['is_valid']) && $data['is_valid']) {
            $data = $data['data'];
        } else {
            $data = [];
        }
        return view('ListRute', compact('data', 'salesman', 'id_salesman'));
    }
}
