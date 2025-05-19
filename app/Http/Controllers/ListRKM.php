<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dataar;
use App\Models\Karyawan;
use App\Models\MasterRute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

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

        // Validasi sederhana
        if (!$nik) {
            return back()->with('error', 'NIK tidak boleh kosong');
        }

        // Kirim request ke API
        $response = Http::post('https://sales.motasaindonesia.co.id/api/spvcall/getDataRkm', [
            'nik' => $nik
        ]);

        if ($response->successful()) {
            $dataApi = $response->json();

            $data = $dataApi['data'] ?? [];
            $message = $dataApi['message'] ?? '';
            $nama = $dataApi['nama'] ?? '';
            $nik = $dataApi['nik'] ?? $nik;

            return view('ListRKM', compact('data', 'message', 'nama', 'nik'));
        } else {
            return back()->with('error', 'Gagal mengambil data dari API');
        }
    }
}
