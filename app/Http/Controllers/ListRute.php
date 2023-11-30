<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dataar;
use App\Models\MasterRute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        $data = [
            'id_salesman' => $id_salesman
        ];

        // Initialize cURL session
        $ch = curl_init();

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, 'http://10.11.1.37/api/downloadrute/getListRute');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded'
        ]);

        // Execute cURL session and get the response
        $response = curl_exec($ch);

        // Check for cURL errors
        if (curl_errno($ch)) {
            $error_message = curl_error($ch);
            // Handle cURL error, for example:
            $message = $error_message;
            curl_close($ch);
            return view('ListRute', compact('message', 'salesman', 'id_salesman'));
        } else {
            // No cURL errors, proceed with processing the response
            curl_close($ch);
            $res = json_decode($response, true);

            $message = '';
            if (isset($res['data']) && $res['is_valid']) {
                $data = $res['data'];
                $message = $res['message'];
                $total = $res['total'];
                $ro = $res['total_ro'];
                $kandidat = intval($res['total']) - intval($res['total_ro']);
                $is_valid = $res['is_valid'];
                return view('ListRute', compact('data', 'salesman', 'id_salesman', 'total', 'ro', 'kandidat'));
            } else {
                $message = $res['message'];
                return view('ListRute', compact('message', 'salesman', 'id_salesman'));
            }
        }
        // return response()->json($res);
        // } catch (\Exception $e) {
        // Tangani kesalahan jika ada
        // return view('ListRute', compact('salesman', 'id_salesman'));
        // }
    }
}
