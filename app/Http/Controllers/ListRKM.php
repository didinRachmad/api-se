<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dataar;
use App\Models\Karyawan;
use App\Models\MasterRute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListRKM extends Controller
{
    public function getKaryawan(Request $request)
    {
        $term = $request->input('q');
        $page = $request->input('page', 1);
        $perPage = 10;

        $query = Karyawan::select('nik', 'nama')->whereNull('resign_date')
            ->where(function ($query) use ($term) {
                $query->where('nik', 'LIKE', '%' . $term . '%')
                    ->orWhere('nama', 'LIKE', '%' . $term . '%');
            })
            ->orderBy('id');

        $karyawan = $query->paginate($perPage, ['*'], 'page', $page);

        $results = [];

        foreach ($karyawan as $data) {
            $nama_wilayah = $data->w->nama_wilayah ?? '';
            $nik_mss = $data->kr->nik_mss ?? '';
            $results[] = [
                'id' => $data->nik,
                'text' => $data->nik,
                'nama' => $data->nama,
            ];
        }

        $response = [
            'results' => $results,
            'pagination' => [
                'more' => $karyawan->hasMorePages(), // Check if there are more pages
            ],
        ];

        return response()->json($response);
    }

    public function getListRKM(Request $request)
    {
        $nama = $request->input('nama');
        $nik = $request->input('nik');

        $data = [
            'nik' => $nik
        ];

        // Initialize cURL session
        $ch = curl_init();

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, 'https://sales.motasaindonesia.co.id/api/spvcall/getDataRkm');
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
            return view('ListRKM', compact('message', 'nama', 'nik'));
        } else {
            // No cURL errors, proceed with processing the response
            curl_close($ch);
            $res = json_decode($response, true);

            $message = '';
            if (isset($res['data']) && $res['is_valid']) {
                $data = $res['data'];
                $message = $res['message'] ?? "Data ditemukan";
                $is_valid = $res['is_valid'];
                return view('ListRKM', compact('data', 'nama', 'nik'));
            } else {
                $message = $res['message'] ?? "Data RKM tidak ditemukan";
                return view('ListRKM', compact('message', 'nama', 'nik'));
            }
        }
        // return response()->json($res);
        // } catch (\Exception $e) {
        // Tangani kesalahan jika ada
        // return view('ListRKM', compact('nama', 'nik'));
        // }
    }
}
